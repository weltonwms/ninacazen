 <!-- Sidebar menu-->
 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
 <aside class="app-sidebar">

   <ul class="app-menu">
     <li><a class="app-menu__item" href="{{ url('/home') }}"><i class="app-menu__icon fa fa-dashboard"></i><span
           class="app-menu__label">Painel de Controle</span></a></li>

     <li><a class="app-menu__item" href="{{route('clientes.index')}}"><i class="app-menu__icon fa fa-users"></i><span
           class="app-menu__label">Clientes</span></a></li>
    <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-gift"></i><span
            class="app-menu__label">Produtos</span></a></li>
    <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-cart-plus"></i><span
              class="app-menu__label">Aluguel</span></a></li>
              <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-user-secret"></i><span
                class="app-menu__label">Usuários</span></a></li>

   </ul>

 </aside>