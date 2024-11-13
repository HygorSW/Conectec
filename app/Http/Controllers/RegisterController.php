<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Likes;
use App\Models\Hashtag;
use App\Models\Seguir;


use App\Models\preferenciasLista;

class RegisterController extends Controller
{
    //
    public function showForm()
    {
        return view('register');
    }

    public function showLoginForm()
{
    return view('login');
}

public function showPostagens()
{   

    $usuariosSugestoes = User::inRandomOrder()->limit(5)->get();
    $user = Auth::user();
    $posts = Post::where('user_id', $user->id)->get();
    $postsCount = $posts->count(); 
    
    return view('postagens',compact('user', 'usuariosSugestoes', 'posts','postsCount'));
}
public function showHome(Request $request)
{
    $user = Auth::user();
    $seguindo = $user->seguindo; 
    $usuariosSugestoes = User::inRandomOrder()->limit(5)->get();
    $preferenciasLista = PreferenciasLista::all();
      // Inicia a consulta para posts
      $postsQuery = Post::with(['hashtags', 'likes', 'comentarios'])
      ->where('status', 1); // Filtra posts com status 1
    

    // Verifica se há uma pesquisa de postagens
    $searchTerm = $request->input('s'); 
        
        

            
        if ($searchTerm) {
            // Buscar usuários
            $users = User::where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('email', 'like', '%' . $searchTerm . '%')
            ->paginate(4);  // Adiciona paginação de 10 usuários por página
            
            // Buscar posts
            $posts = Post::where('texto', 'like', '%' . $searchTerm . '%')
                ->orWhere('texto', 'like', '%' . $searchTerm . '%')
                ->get();
        } else {
        
            $users = collect();   
// Obtém os IDs dos usuários que o usuário está seguindo
$seguindoIds = $user->seguindo()->pluck('seguindo_id'); // Se "seguindo_id" é a coluna que contém os IDs dos usuários seguidos

// Obtém as hashtags dos posts que o usuário curtiu
$likedHashtags = $user->likes()
    ->with('post.hashtags') // Carrega as hashtags dos posts curtidos
    ->get()
    ->pluck('post.hashtags.*.id') // Plana para obter uma lista única de IDs de hashtags
    ->flatten()
    ->unique();

// Inicia a consulta para obter todos os posts
$postsQuery = Post::with(['hashtags', 'likes', 'comentarios']) // Inclui hashtags, likes e comentários
    ->where('status', 1); // Filtra posts com status 1

// Cria uma condição para incluir posts apenas de usuários seguidos ou posts relevantes
$postsQuery->where(function($query) use ($seguindoIds, $likedHashtags, $user) {
    // Adiciona posts de usuários que o usuário está seguindo
    if ($seguindoIds->isNotEmpty()) {
        $query->whereIn('user_id', $seguindoIds);
    }

    // Adiciona posts com hashtags que o usuário curtiu
    if ($likedHashtags->isNotEmpty()) {
        $query->orWhereHas('hashtags', function($subQuery) use ($likedHashtags) {
            $subQuery->whereIn('hashtags.id', $likedHashtags);
        });
    }

    // Adiciona posts de usuários com o mesmo perfil/curso que o usuário autenticado
    $query->orWhereHas('user', function($subQuery) use ($user) {
        $subQuery->where('perfil', $user->perfil); // Filtra usuários pelo perfil/curso do usuário autenticado
    });
});

// Ordena os posts
// Monta a cláusula de prioridade apenas se houver IDs seguidos
if ($seguindoIds->isNotEmpty()) {
    $posts = $postsQuery->select('posts.*')
        ->orderByRaw('CASE WHEN user_id IN (' . $seguindoIds->implode(',') . ') THEN 0 ELSE 1 END') // Coloca posts dos seguidos no topo
        ->orderBy('created_at', 'desc') // Ordena do mais recente para o mais antigo
        ->paginate(10); // Paginação para controle de performance
} else {
    // Se não houver IDs seguidos, apenas ordene por data de criação
    $posts = $postsQuery->select('posts.*')
        ->orderBy('created_at', 'desc') // Ordena do mais recente para o mais antigo
        ->paginate(10); // Paginação para controle de performance
}
        }


    return view('home', compact('user', 'users', 'posts', 'preferenciasLista', 'usuariosSugestoes', 'searchTerm'));
}

public function getHashtagsByCurso(User $user)
{
    // Defina as hashtags para cada curso
    $hashtagsPorCurso = [
        'Ds' => ['programacao', 'laravel', 'PHP'],
        'Nutri' => ['nutricao', 'saude', 'alimentacao'],
        'Adm' => ['gestao', 'administracao', 'marketing'],
    ];

    // Verifique o perfil do usuário e retorne as hashtags associadas
   
    if (array_key_exists($user->perfil, $hashtagsPorCurso)) {

        return Hashtag::whereIn('hashtag', $hashtagsPorCurso[$user->perfil])->get();
    }

    return collect(); // Se o perfil não for encontrado, retorne uma coleção vazia
}



    public function register(Request $request)

    {
        if (!str_contains($request->input('email'), 'etec')) {
            return redirect()->back()->withErrors([
                'email' => 'O email precisa conter "etec".',
            ]);
        }

        $profilePhotoUrl = 'img/default.jpg';

        if ($request->hasFile('urlDaFoto')) {
            $file = $request->file('urlDaFoto');
            $profilePhotoUrl = $file->store('urlDaFoto', 'public');
        } 
            

        User::create([
            'name' => $request->input('name'),
            'arroba' => $request->input('arroba'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'urlDaFoto' => $profilePhotoUrl,
            'modulo' => $request->input('module'),
            'perfil' => $request->input('role'),
            'bio' => $request->input('bio'), // Adiciona o campo bio

           
        ]);

        return redirect()->route('login')->with([
            'status' => 'Usuário registrado com sucesso',
            'showModal' => true,
        ]);

    }




   public function login(Request $request){

    

     $credentials = $request->only('email','password');
     $autenticado =Auth::attempt($credentials);
        if(!$autenticado){
            return redirect()->route('login')->withErrors(['error' =>'Email ou senha errada']);

        }
        $user = Auth::user();

        // Verificando o status do usuário
        if ($user->status === 'Off') {
            Auth::logout(); // Deslogar o usuário
            return redirect()->route('login')->withErrors(['error' => 'Sua conta está desativada.']);
        }
        
        return redirect()->route('home', )->with(['success' =>'Logou']);
       
    }


    public function logout(Request $request)
    {
        Auth::guard()->logout();

        // Invalida a sessão atual e regenera o token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redireciona para a página de login
        return redirect('/login');
    }



    public function update(Request $request, $postID)
    {
        // Validação dos dados do formulário
        $request->validate([
            'texto' => 'required|string',
            'fotoPost' => 'nullable|image|max:2048',
        ]);
    
        // Encontrar o post pelo ID
        $post = Post::findOrFail($postID);

        if ($request->hasFile('urlDoBanner')) {
            $file = $request->file('urlDoBanner');
            $profilePhotoUrl = $file->store('urlDoBanner', 'public');
        } 
    
        // Atualizar o conteúdo do post
        $post->update([
            'texto' => $request->input('texto'),
            'fotoPost' => $request->file('fotoPost') ? $request->file('fotoPost')->store('posts') : $post->fotoPost,
        ]);
    
        // Redirecionar com sucesso
        return redirect()->route('postagens')->with('status', 'Post atualizado com sucesso!');
    }
    
    






}