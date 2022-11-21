@extends('admin.main')

@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ count($newOders) }}</h3>
  
                  <p>Đơn hàng mới</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="/admin/customers" class="small-box-footer">More info<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ count($shipOders) }}</h3>
  
                  <p>Đơn đang giao</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="/admin/customers" class="small-box-footer">More info<i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <!-- ./col -->

            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>{{ count($cancelOders) }}</h3>
  
                  <p>Đơn hủy</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="/admin/customers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ count($successOrders) }}</h3>
  
                  <p>Đơn giao thành công</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="/admin/customers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <!-- ./col -->
            
            <!-- ./col -->
          </div>

          <img src="/template/images/ntcstore.png" alt="" width="100%">
    </div>
@endsection



