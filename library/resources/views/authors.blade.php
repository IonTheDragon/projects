@extends('layouts.app')

@section('content')

<link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<style>
	.paginate_button:last-of-type
	{
		display: none !important;
	}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Авторы
				@auth
				<div class="top-right links" style="top: 10px;"><a href="{{ url('/add_author_form') }}">Добавить автора</a></div>
				@endauth
				</div>

                <div class="card-body">
					<div class="links">
						
						<table id="datatable" class="display" style="width:100%">
								<thead>
									<tr>
										<th>Имя</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>Имя</th>
									</tr>
								</tfoot>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

	<script>	
		var datatable = $('#datatable').DataTable( {
			serverSide: true,
			ajax: "{{ url('get_authors') }}",
			language: {
				lengthMenu:    "Показать _MENU_ записей",
				info:           "",
				infoEmpty:      "",
				infoFiltered:   "",
				search:         "Поиск по имени&nbsp;:",
				loadingRecords: "Загрузка...",
				zeroRecords:    "Пусто",
				emptyTable:     "Пусто",
				paginate: {
					first:      "Первая",
					previous:   "Предыдущая",
					next:       "Следующая",
					last:       "Последняя"
				}
			},
			ordering:  false,
			searching:  false,
			pagingType: "numbers",
		} );
	</script>

@endsection