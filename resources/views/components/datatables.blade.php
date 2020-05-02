{{-- resources/views/components/datatables.blade.php --}}

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                @if(isset($bsResponsive))
                <div class="table-responsive">
                @endif

                <table class="table table-hover table-bordered nowrap" id="dataTable1">
                    {{ $slot }}
                </table>
                @if(isset($bsResponsive))
                </div>
                @endif

                <!--dependencia dataTableSubmit-->
                <form id="adminForm" action="" method="POST" style="display: none;">
                    @csrf
                </form>
                <!--dependencia dataTableSubmit-->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript" src="{{ asset('template/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<!--responsive datatables e datatables selecionavel-->
<script type="text/javascript" src="{{ asset('template/js/plugins/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/js/plugins/responsive.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('template/js/plugins/dataTables.select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tabela.js') }}"></script>


@endpush