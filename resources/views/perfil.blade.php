<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{url('assets/css/visitante.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/nav.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/postPadrão.css')}}">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Conectec Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontisto/3.0.1/css/fontisto/fontisto.min.css" integrity="sha512-OCX+kEmTPN1oyWnFzjD7g/7SLd9urTeI/VUZR6nZFFN7sedDoBSaSv/FDvCF8hf1jvadHsp0y0kie9Zdm899YA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>




<body>

    @include('partials.navbar')

    <!-------------------------------------------  NavAbar -------------------------------------------------------------------------------------->

    <main>
    @php
                    $coresModulo = [
                            '1º' => '#CD4642',
                            '2º' => '#5169B1',
                            '3º' => '#64B467',
                            ];
                            @endphp
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
                        <a class="menu-item " href="{{Route('chat.list')}}">
                            <span><i class="fa-regular fa-message"></i></span>
                            <h3>Chat</h3>
                        </a>

                        <a class="menu-item "  href="{{ Route('home')}}">
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



            <!-------------------------------------------  Posts -------------------------------------------------------------------------------------->





            <div class="meio">
                <div class="perfilContainer">
                    <div class="fundo">
                        <img src="{{ asset('storage/' . $usuario->urlDoBanner) }}" id="banner">
                        <a href="javascript:void(0);" onclick="openModal({{ $usuario->id }})">
                                <span class="material-symbols-outlined iconDenuncia">warning</span>
                            </a>
                    </div>


                    <img src="{{ asset('storage/' . $usuario->urlDaFoto) }}" id="icon">


                    <div class="infoContainer">
                        <div class="rowEditarPerfil">
                        <form action="/conversations" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="username" value="{{ $usuario->arroba }}">
                                <button type="submit" class="btnChat">
                                    <span class="material-symbols-outlined">
                                        forum
                                    </span>
                                </button>
                            </form>

                            <button class="follow-btn"
                                data-user-id="{{ $usuario->id }}"
                                data-action="{{ Auth::user()->seguindo()->where('seguindo_id', $usuario->id)->exists() ? 'unfollow' : 'follow' }}">
                                {{ Auth::user()->seguindo()->where('seguindo_id', $usuario->id)->exists() ? 'Seguindo' : 'Seguir' }}
                            </button>


                            {{-- aqui --}}


                            <!-- Link que abre o modal -->







                        </div>

                        <!-- Modal -->
                        <div id="modal-denuncia" class="modal" style="display: none;">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal()">&times;</span>
                                <h2>Denunciar Usuário</h2>
                                <p>Deseja realmente denunciar o usuário {{ $usuario->name }}?</p>
                                <input type="text" id="motivo" placeholder="Motivo da denúncia">
                                <div class="modal-footer">
                                    <button class="btn btn-danger" onclick="closeModal()">Cancelar</button>
                                    <button class="postarBotao" onclick="confirmarDenuncia()">Confirmar</button>
                                </div>
                                <input type="hidden" id="user-id" value="{{ auth()->user()->id }}">
                                <input type="hidden" id="user_denunciado_id" value="{{ $usuario->id }}">

                            </div>
                        </div>

                        <!-- Estilos para o modal -->
                        <style>
                                #motivo {
                                    outline: none;
                                    background-color: #eaeaea;
                                    padding: 4px;
                                    border-radius: 12px;
                                    border: none;
                                    height: 40px;
                                    padding: 0px 10px 0px 10px;

                                }

                                .icons-group {
                                    display: flex;
                                    justify-content: center
                                }

                                .modal {
                                    display: none;
                                    position: fixed;
                                    z-index: 1;
                                    padding-top: 100px;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                    height: 100%;
                                    overflow: auto;
                                    background-color: rgba(0, 0, 0, 0.4);
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                }

                                .modal-content {
                                    background-color: #fefefe;
                                    padding: 20px;
                                    border: 1px solid #888;
                                    width: 50%;
                                    /* Ajuste para 50% da largura */
                                    max-width: 600px;
                                    /* Limite opcional de largura máxima */
                                }

                                .close {
                                    color: #646464;
                                    float: right;
                                    font-size: 28px;
                                    font-weight: bold;
                                }

                                .close:hover,
                                .close:focus {
                                    color: rgb(49, 48, 48);
                                    text-decoration: none;
                                    cursor: pointer;
                                }
                            </style> 

                        <!-- Scripts para abrir e fechar o modal -->
                        <script>
                            function openModal(postId) {
                                document.getElementById('modal-denuncia').style.display = 'flex';
                            }

                            function closeModal() {
                                document.getElementById('modal-denuncia').style.display = 'none';
                            }

                            function confirmarDenuncia() {
                                    const userId = document.getElementById('user-id').value; // ID do usuário que fez a denúncia
                                    const postId = document.getElementById('post-id').value; // ID do post denunciado
                                    const motivo = document.getElementById('motivo').value; // Motivo da denúncia

                                    fetch("{{ route('denunciar') }}", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                            },
                                            body: JSON.stringify({
                                                user_id: userId,
                                                post_id: postId,
                                                motivo: motivo
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Denúncia registrada!',
                                                text: data.message,
                                                confirmButtonText: 'Ok'
                                            }).then(() => {
                                                closeModal(); // Fecha o modal após o alerta
                                            });
                                        })
                                        .catch(error => {
                                            console.error("Erro:", error);
                                            Swal.fire({
                                                icon: 'error',  
                                                title: 'Erro',
                                                text: 'Ocorreu um erro ao registrar a denúncia.',
                                                confirmButtonText: 'Ok'
                                            });
                                        });
                                }



                        </script>


                        {{-- aqui --}}


                    </div>
                    <div class="rowNomeUser">
                        <div class="nomeecurso">
                                <h1 class="username">{{ $usuario->name}}</h1>
                                
                                <div class="modulo-div" style="background-color: {{ $coresModulo[$usuario->modulo] ?? 'defaultColor' }};">
                                        <p>{{ $usuario->modulo }} {{ $usuario->perfil }} </p>
                                    </div>
                            </div>
                        <p class="arroba"> {{ '@' . $usuario->arroba }} </p>
                    </div>

                    <div class="rowBio">
                        <div class="bio">
                            <p>{{ $usuario->bio }}</p>
                        </div>
                    </div>

                    <div class="footerPerfil">
                        <div class="itensData">
                            <span class="material-symbols-outlined">
                                calendar_month
                            </span>
                            <p>{{ $usuario->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="itensFollow">
                            <p>{{$seguindo}} Seguindo</p>
                            <p>{{$myseguidores}} Seguidores</p>
                        </div>
                    </div>

                    <div class="categoriaFooter">
                        <div class="categoria" onclick="mudarConteudo('meusPosts')">Postagens</div>
                    </div>


                </div>




                <div id="resultado" class="resultado">
                    @foreach($posts as $post)
                    @php
                    $coresModulo = [
                    '1º' => '#CD4642',
                    '2º' => '#5169B1',
                    '3º' => '#64B467',
                    ];
                    @endphp
                    <div class="feeds">
                        <div class="feed">
                            <div class="user">
                                <div class="profileImg">
                                    <a href="{{ route('perfil', ['id' => $post->user->id]) }}">
                                        <img src="{{ asset('storage/' . $post->user->urlDaFoto) }}" alt="" class="perfilPostImg">
                                    </a>
                                </div>
                                <div class="info">
                                    <div class="infoHeader" style="display:flex; align-items:center; justify-content:space-between; width:100%">
                                        <h3>{{ '@' . $post->user->name }} <span class="publiSpan"> • fez uma nova publicação</span></h3>
                                        <div class="modulo-div" style="background-color: {{ $coresModulo[$post->user->modulo] ?? 'defaultColor' }};">
                                            <p>{{ $post->user->modulo }} {{ $post->user->perfil }}</p>
                                        </div>
                                    </div>
                                    <p class="horaPost">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="textoPost">{{ $post->texto ?? 'Post não disponível' }}</div>

                            @if($post->fotoPost)
                            <div class="imgPost">
                                <a href="{{ asset('storage/' . $post->fotoPost) }}" data-lightbox="gallery" data-title="Descrição da imagem">
                                    <img src="{{ asset('storage/' . $post->fotoPost) }}" alt="" style="max-width: 100%; height: auto;">
                                </a>
                            </div>
                            @endif

                            <div class="action-button">
                                <div class="interaction-button">
                                    <span class="like-btn @if($post->likes()->where('user_id', Auth::id())->exists()) liked @endif" data-post-id="{{ $post->id }}">
                                        @if($post->likes()->where('user_id', Auth::id())->exists())
                                        <i class="fas fa-heart liked"></i>
                                        @else
                                        <i class="far fa-heart"></i>
                                        @endif
                                    </span>
                                    <span class="likes-count">{{ $post->likes()->count() }}</span>
                                    <a href="{{ route('comentarios', $post->id) }}">
                                        <button class="comentarioCotn">
                                            <i class="uil uil-comment"></i>
                                        </button>
                                    </a>
                                </div>

                                <div class="icons-group2">
                                <span class="salvo-btn @if($post->salvos()->where('user_id', Auth::id())->exists()) salvo @endif" data-post-id="{{ $post->id }}">
                                    @if($post->salvos()->where('user_id', Auth::id())->exists())
                                    <i class="fa-solid fa-bookmark salvo"></i>
                                    @else
                                    <i class="fa-regular fa-bookmark"></i>
                                    @endif
                                </span>

                                <a class="iconDenuncia2" href="javascript:void(0);" onclick="openModal({{ $post->id }})">
                                    <span class="material-symbols-outlined">
                                        emergency_home
                                        </span>
                                </a>
                                </div>

                                                            <!-- Modal denuncia -->
                            <div id="modal-denuncia" class="modal" style="display: none;">
                                <div class="modal-content"> 
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <h2>Denunciar Post</h2>
                                    <p>Deseja realmente denunciar o post de {{ '@' . $post->user->arroba }}?</p> 
                                    <input type="text" id="motivo" placeholder="Motivo da denúncia">
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" onclick="closeModal()">Cancelar</button>
                                        <button class="postarBotao" onclick="confirmarDenuncia()">Confirmar</button>
                                    </div>
                                    <input type="hidden" id="user-id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" id="post-id" value="{{ $post->id }}">

                                </div>
                            </div>

                            


                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @include ('partials.emAlta')
        </div>
        </div>



    </main>
    @include('partials.modalsair')
    <!-- Modal de Confirmação -->

    <script>
                         // Função para abrir o modal
function openModal(userId) {
    document.getElementById('modal-denuncia').style.display = 'flex';
    document.getElementById('user_denunciado_id').value = userId; // Preenche o ID do usuário denunciado
}

// Função para fechar o modal
function closeModal() {
    document.getElementById('modal-denuncia').style.display = 'none';
}

// Função para confirmar a denúncia
function confirmarDenuncia() {
    const userId = document.getElementById('user-id').value; // ID do usuário que está denunciando
    const postId = document.getElementById('user_denunciado_id').value; // ID do usuário denunciado
    const motivo = document.getElementById('motivo').value; // Motivo da denúncia

    if (!motivo) {
        alert("Por favor, informe o motivo da denúncia.");
        return;
    }

    fetch("{{ route('denunciarUser') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            user_id: userId,
            user_denunciado_id: postId,
            motivo: motivo
        })
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Denúncia registrada!',
            text: data.message,
            confirmButtonText: 'Ok'
        }).then(() => {
            closeModal(); // Fecha o modal após o alerta
        });
    })
    .catch(error => {
        console.error("Erro:", error);
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Ocorreu um erro ao registrar a denúncia.',
            confirmButtonText: 'Ok'
        });
    });
}


                            </script>

<script src="{{ asset('js/salvo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/seguir.js') }}"></script>

</body>

</html>