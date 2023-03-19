@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المرفقات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

<!----------------------------رسالة اضافة المرفق بنجاح----------->
@if (session()->has('add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('add') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
<!---------------------------رساله خطا فى التحقق------------------------------------>



@if($errors->any())
<div class="alert alert-danger">
<ul>
@foreach($errors->all() as $error)


<li>

{{$error}}

</li>

@endforeach

</ul>
</div>
@endif
<!-------------------------------------------------------رسالة حذف المرفق---------------------------------------------------->

    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
				<!-- row -->
				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<div>
									<form action="{{ route('create_attachments') }}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="mb-3">

											<label for="formFile" class="form-label">اضافة مرفقات</label>

											<input class="form-control" type="file"  name="file" id="formFile">

											<input class="form-control" type="hidden"  name="invoice_id" value="{{ $invoice->id }}">

											<input class="form-control" type="hidden"  name="invoice_number" value="{{ $invoice->invoice_number }}">


											<input class="form-control" type="hidden"  name="invoice_status" value="{{ $invoice->status}}">


											<input class="form-control" type="hidden"  name="invoice_date" value="{{ $invoice->invoice_date}}">


											<input class="form-control" type="hidden"  name="due_date" value="{{ $invoice->due_date}}">

										<button type="submit" class="btn btn-primary">تأكيد</button>

										  </div>

									  </form>
								</div>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
											<tr>
												<th class="wd-10p border-bottom-0">المسلسل </th>
												<th class="wd-15p border-bottom-0"> رقم الفاتورة </th>
												<th class="wd-10p border-bottom-0">اسم الملف</th>
												<th class="wd-10p border-bottom-0">قام بالاضافة </th>
												<th class="wd-10p border-bottom-0"> حالة الفاتورة </th>
												<th class="wd-10p border-bottom-0">تاريخ الاضافة</th>
												<th class="wd-15p border-bottom-0">تاريخ الدفع</th>
												<th class="wd-25p border-bottom-0"> العمليات</th>

											</tr>
										</thead>
										<tbody>
											<?php $i=0 ?>
											@foreach($invoice_attachments as $attachment)
											<?php  $i++     ?>
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $attachment->invoice_number }}</td>
												<td>{{ $attachment->name }} </td>
												<td>{{ $attachment->user }}</td>
												<td>{{ $attachment->invoices->status }}</td>
												<td>{{ $attachment->add_date }}</td>
												<td>{{ $attachment->due_date }}</td>
												<td>

													<span><a class="btn btn-outline-success btn-sm"
													href="{{ route('view_file',$attachment->id) }}"
													role="button"><i class="fas fa-eye"></i>&nbsp;
													عرض</a></span>

												<span><a class="btn btn-outline-info btn-sm"
													href="{{ route('download_file',$attachment->id) }}"
													role="button"><i
														class="fas fa-download"></i>&nbsp;
													تحميل</a></span>

												<span>	<button class="btn btn-outline-danger btn-sm"
														data-toggle="modal"
														data-file_name="{{ $attachment->name }}"
														data-invoice_number="{{ $attachment->invoice_number }}"
														data-id_file="{{ $attachment->id}}"
														data-target="#delete_files">حذف</button>

													</span>
												</td>

											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- Modal effects -->
		<div class="modal" id="delete_files">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">حذف المرفق</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{ route('delete_attachment') }}" method="POST">
							@method('GET')
						<h6>هل تريد حذف المرفق؟ </h6>
						<input type="hidden" name="id" id="id">
						<input type="text" name="name" id="name">
						<input type="hidden" name="number" id="number">

					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="submit">تأكيد </button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
					</div>
				</form>
				</div>
			</div>
		</div>
		<!-- End Modal effects-->

		<!-- main-content closed -->



@endsection

@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!-------------------------------------------كود جافا لحذف المرفق-------------------------->
<script>

	$('#delete_files').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id_file = button.data('id_file')
		var invoice_number= button.data('invoice_number')
		var file_name = button.data('file_name')

		var modal = $(this)
		modal.find('.modal-body #id').val(id_file);
		modal.find('.modal-body #name').val(file_name);
		modal.find('.modal-body #number').val(invoice_number);

	})

</script>


@endsection
