<div ng-app="admin_frontend" ng-controller="AppCtrl" id="admin_frontend" layout="column"  ng-cloak>

    <div class="row main">

        <sidebar class="s-15">
            <div class="avatar">
                <img class="imagen-usuario" src="/wp-content/plugins/ser_lib/assets/img/avatar-default.jpg">
                <div class="name">Brayan Stivel Bernal Garcia</div>
                <div class="rol">Admin</div>
            </div>
            <div class="navigation">
                <ul>
                    <li class="menu"  ui-sref-active="{'active': 'publicaciones'}" aria-hidden="false">
                        <div class="title">PUBLICACIONES</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'publicaciones.all'}" ui-sref="publicaciones.all">Publicaciones </a></li>
                            <li ><a ui-sref-active="{'active': 'publicaciones.form'}" ui-sref="publicaciones.form">Agregar nueva</a></li>
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