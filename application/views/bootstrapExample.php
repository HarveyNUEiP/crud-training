<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Bootstrap 4 Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<script src="/node_modules/jquery/dist/jquery.min.js"></script>
	<script src="/node_modules/popper.js"></script>
	<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
</head>

<body>

	<div class="container">
		<!-- Title -->
		<div class="row">
			<div class="col-sm-12">
				<h1>帳號管理</h1>
			</div>
		</div>

		<!-- Controll Form -->
		<div class="row">
			<div class="col-sm-4 form-group">
				<input type="password" class="form-control" id="pwd">
			</div>
			<div class="col-sm-4"><button class="btn btn-primary">搜尋</button></div>
			<div class="col-sm-4"><button class="btn btn-warning float-right" data-toggle="modal" data-target="#myModal">新增</button></div>
		</div>

		<!-- Table -->
		<div class="row">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>&nbsp</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><i class="fas fa-pen color_green ml-3"></i> <i class="fas fa-trash text-danger ml-3"></i></td>
						<td>John</td>
						<td>Doe</td>
						<td>john@example.com</td>
					</tr>
					<tr>
						<td><i class="fas fa-pen color_green ml-3"></i> <i class="fas fa-trash text-danger ml-3"></i></td>
						<td>Mary</td>
						<td>Moe</td>
						<td>mary@example.com</td>
					</tr>
					<tr>
						<td><i class="fas fa-pen color_green ml-3"></i> <i class="fas fa-trash text-danger ml-3"></i></td>
						<td>July</td>
						<td>Dooley</td>
						<td>july@example.com</td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- Pagination -->
		<div class="row float-right">
			<ul class="pagination">
				<li class="page-item"><a class="page-link" href="#">Previous</a></li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item"><a class="page-link" href="#">Next</a></li>
			</ul>
		</div>
	</div>


	<!-- The Modal -->
	<div class="modal" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Modal Heading</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					Modal body..
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>

</body>

</html>