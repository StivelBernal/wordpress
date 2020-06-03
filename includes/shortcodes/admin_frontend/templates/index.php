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

                    <li class="menu"  ui-sref-active="{'active': 'patients'}" aria-hidden="false">
                           <div class="title">PUBLICACIONES</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'patients.appointment'}" ui-sref="patients.appointment" href="#!/patients/appointment">Agenda de citas </a></li>
                            <li ><a ui-sref-active="{'active': 'patients.list'}" ui-sref="patients.list" href="#!/patients/list">Pacientes </a></li>
                        </ul>
                    </li>
                    
                    <li class="menu" ui-sref-active="{'active': 'forms'}" aria-hidden="false">
                        <div class="title">EDITAR PERFIL</div>
                        <ul class="submenu">
                            <li ><a ui-sref-active="{'active': 'forms'}" ui-sref="forms.builder" href="#!/forms/builder">Gestor de formularios </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </sidebar>
        <div class="s-flex page">
            <div class="row toolbar-actions">
                <h2 md-truncate="" flex="">PUBLICACIONES</h2>
                <div class="s-flex"></div>
        
                <md-button>
                    Actions
                </md-button>
            </div>
        </div>
    
    </div>
  
  </div>