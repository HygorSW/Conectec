<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Conversas</title>
    <link rel="stylesheet" href="{{url('assets/css/listaContatos.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/nav.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link
        rel="stylesheet"
        href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/fontisto/3.0.1/css/fontisto/fontisto.min.css" integrity="sha512-OCX+kEmTPN1oyWnFzjD7g/7SLd9urTeI/VUZR6nZFFN7sedDoBSaSv/FDvCF8hf1jvadHsp0y0kie9Zdm899YA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    @include('partials.navbar')



    <main>
        <div class="container">
            <div class="left">
                <div class="sidebar">
                    <div class="sidebarList">

                    <a href="{{ Route('home')}}" class="menu-item ">
                            <span><i class="fa-solid fa-house"></i></span>
                            <h3>Home</h3>
                        </a>

                        <a class="menu-item " href="{{ Route('explorar')}}">
                            <span><i class="fa-regular fa-compass"></i></span>
                            <h3>Explorar</h3>
                        </a>

                        <a class="menu-item" href="{{ Route('notificacoes.index')}}">
                            <span><i class="fa-regular fa-bell"></i></span>
                            <h3>Notificações</h3>
                            @if($naoLidasCount > 0)
                            <span class="badge rounded-pill text-bg-danger">{{$naoLidasCount}}</span>
                            @endif
                        </a>

                        <a href="{{ Route('postagens')}}" class="menu-item">
                            <span><i class="fa-regular fa-images"></i></span>
                            <h3>Postagens</h3>
                        </a>
                        <a class="menu-item active" href="{{Route('chat.list')}}">
                            <span><i class="fa-regular fa-message"></i></span>
                            <h3>Chat</h3>
                        </a>

                        <a class="menu-item " href="{{ Route('home')}}">
                            <span><i class="fa-regular fa-square-plus"></i></i></span>
                            <h3>Criar</h3>
                        </a>


                    </div>

                    <a href="{{ route('profile', ['id' => $user->id]) }}" class="menu-item">
                        <div class="imgPerfilSide">
                            <img src="{{ asset('storage/' . $user->urlDaFoto) }}" alt="">
                            <div class="sidePerfilNames">
                                <h3>{{$user->name }}</h3>
                                <span class="arrobaSide">{{ '@'. $user->arroba}}</span>
                            </div>
                        </div>
                    </a>




                </div>
            </div>
            <div class="listaContainer">
                <div class="headerContatos">
                    <h1>Chat</h1>
                    <button data-bs-toggle="modal" data-bs-target="#profileModal" class="addUser">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                </div>
                

                <div class="conversationsLista">

                    @foreach($conversations as $conversation)
                    <div class="contato">


                        <a href="{{ url('/conversations/' . $conversation->id) }}">
                            <li>
                            <div class="nameContato">
                                <div class="imgContato">
                                    <img src="{{ asset('storage/' . ($conversation->user_one_id === $user->id ? $conversation->userTwo->urlDaFoto : $conversation->userOne->urlDaFoto)) }}" class="imgLista" alt="">
                                </div>
                                    <div class="infosContato">
                                    <span> {{ $conversation->user_one_id === $user->id ? $conversation->userTwo->name : $conversation->userOne->name }} </span>
                                    <span id="nome">{{$conversation->userTwo->arroba}}</span>

                                    <div class="horasMsgContato"><span id="horaMsgConta">5:14</span></div>
                                </div>
                                
                            </div>
                                

                            </li>
                        </a>

                    </div>
                    @endforeach

                </div>
            </div>
            </div>

            @include('partials.modalContato')



        <div class="imagemConectecCont">
            <div class="imagemConversa">
                <img src="{{url('assets/img/Work chat-pana.png')}}" alt="">
                <div class="titulo">
                    <h1>Conectec</h1>
                    <span>"Bem-vindo ao Conecte Chat! Aqui é um lugar para compartilhar ideias, aprender juntos e se conectar com colegas. Sinta-se à vontade para fazer perguntas, participar das discussões e colaborar com a comunidade. Vamos juntos construir um espaço de aprendizado e troca de experiências!"</span>
                </div>
            </div>

            
            
        </div>
        </div>

    </main>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    @include('partials.modalsair')
</body>

</html>