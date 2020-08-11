<div ng-app="admin_frontend" ng-controller="AppCtrl" id="admin_frontend" layout="column"  ng-cloak>

    <div class="row main">

        <sidebar class="s-15">
            <div class="avatar">
                <img class="imagen-usuario" ng-src="{{img_profile}}">
                <div class="name">{{name}}</div>
                <div class="rol">{{rol}}</div>
            </div>
            <div class="navigation">
                <ul>
                    <li ng-if="rol === 'turista'" class="menu"  ui-sref-active="{'active': 'publicaciones'}" aria-hidden="false">
                        <div  class="title">PUBLICACIONES</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'publicaciones.all'}" ui-sref="publicaciones.all">Publicaciones </a></li>
                            <li ><a ui-sref-active="{'active': 'publicaciones.create'}" ui-sref="publicaciones.create">Agregar nueva</a></li>
                        </ul>
                    </li>

                    <li ng-if="rol === 'comerciante'" class="menu"  ui-sref-active="{'active': 'publicaciones'}" aria-hidden="false">
                        <div  class="title">NEGOCIOS</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'negocios.all'}" ui-sref="negocios.all">Negocios </a></li>
                            <li ><a ui-sref-active="{'active': 'negocios.create'}" ui-sref="negocios.create">Agregar nuevo</a></li>
                        </ul>
                    </li>

                    <li ng-if="rol === 'alcaldia'" class="menu"  ui-sref-active="{'active': 'articulos'}" aria-hidden="false">
                        <div  class="title">PUBLICACIONES</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'articulos.all'}" ui-sref="articulos.all">Publicaciones alcaldia</a></li>
                            <li ><a ui-sref-active="{'active': 'articulos.create'}" ui-sref="articulos.create">Agregar nueva</a></li>
                        </ul>
                    </li>

                    <li ng-if="rol === 'gobernacion'" class="menu"  ui-sref-active="{'active': 'articulos'}" aria-hidden="false">
                        <div  class="title">PUBLICACIONES</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'articulos.all'}" ui-sref="articulos.all">Publicaciones gobernación </a></li>
                            <li ><a ui-sref-active="{'active': 'articulos.create'}" ui-sref="articulos.create">Agregar nueva</a></li>
                        </ul>
                    </li>

                    <li ng-if="rol === 'aliado'" class="menu"  ui-sref-active="{'active': 'articulos'}" aria-hidden="false">
                        <div  class="title">PUBLICACIONES</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'articulos.all'}" ui-sref="articulos.all">Publicaciones</a></li>
                            <li ><a ui-sref-active="{'active': 'articulos.create'}" ui-sref="articulos.create">Agregar nueva</a></li>
                        </ul>
                    </li>

                    <li class="menu" ui-sref-active="{'active': 'profile'}" aria-hidden="false">
                        <div class="title">EDITAR PERFIL</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'profile': 'forms'}" ui-sref="profile">Editar perfil </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </sidebar>
        <div class="s-flex page">
            <div class="main-view" ui-view></div>
        </div>
    
    </div>
  
  </div>