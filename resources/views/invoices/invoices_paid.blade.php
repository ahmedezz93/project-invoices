@extends('layouts.master')
@section('title')
    الفواتير المدفوعة
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير
                    المدفوعة
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


<!-----------------------------------------------رساله حذف الفاتوره بنجاح-------------------->



    @if (session()->has('archive'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('archive') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
<!------------------------------------------رسالة ارشفه الفاتورة---------------------------------------------->
    <!-- row -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ القاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 0;
                                @endphp
                                @foreach ($invoices as $invoice)
                                    @php
                                    $i++
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $invoice->invoice_number }} </td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->section->name }}</td>
                                        <td>{{ $invoice->discount }}</td>
                                        <td>{{ $invoice->rate_vate }}</td>
                                        <td>{{ $invoice->value_vate }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>{{ $invoice->status }}</td>
                                        <td>{{ $invoice->notes }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-warning" data-toggle="dropdown" type="button">العمليات <i class="fas fa-caret-down mr-1"></i></button>
                                                <div class="dropdown-menu tx-13">
                                                    <a class="dropdown-item" href="{{ route('edit_invoice',$invoice->id) }}">تعديل </a>

                                                    <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                        data-toggle="modal" data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                        الفاتورة</a>
                                                    <a class="dropdown-item" href="{{ route('change_payment',$invoice->id) }}">تغيير حالة الدفع  </a>

                                                    <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                        data-toggle="modal" data-target="#Transfer_invoice"><i
                                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                        الارشيف</a>


                                                </div>
                                            </div>
    
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

    <!-- حذف الفاتورة -->
 


    <!-- ارشيف الفاتورة -->
    

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
    		<!-- Modal effects -->
		<div class="modal" id="delete_invoice">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">حذف الفاتورة </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
                    <form action="{{ route('delete_paid_invoice')}}" method="POST">
                        @csrf
                        @method('GET')
					<div class="modal-body">
						<h6>هل تريد حذف الفاتورة؟ </h6>
                        <div>
                            <input type="hidden" name="id" id="id"  value="">
    
                        </div>
    
					</div>
					<div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
						<button class="btn ripple btn-danger" type="submit">تأكيد </button>
					</div>
                </form>

				</div>
			</div>
		</div>
		<!-- End Modal effects-->

            		<!-- Modal effects -->
		<div class="modal" id="Transfer_invoice">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">حذف الفاتورة </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
                    <form action="{{ route('archived_invoice')}}" method="POST">
                        @csrf
                        @method('GET')
					<div class="modal-body">
						<h6>هل تريد نقل الفاتورة الى الارشيف ؟ </h6>
                        <div>
                            <input type="hidden" name="id" id="id"  value="">
    
                        </div>
    
					</div>
					<div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
						<button class="btn ripple btn-danger" type="submit">تأكيد </button>
					</div>
                </form>

				</div>
			</div>
		</div>
		<!-- End Modal effects-->


@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(invoice_id);
        })

    </script>

    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(invoice_id);
        })

    </script>


@endsection