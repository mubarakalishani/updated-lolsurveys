@extends('layouts.afterlogin')
@section('content')
<div class="container-fluid">

  <!-- user faucet start -->
  <div class="all-history-page all-surveys-page">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 my-4">
          <div class="heading-section">
            <h4><em>Our Crypto</em> Faucet</h4>
          </div>
          <div class="alert alert-with-icon alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-bullhorn" aria-hidden="true"></i>
            <strong>Attention!</strong><br>
            Happy hour (+10% bonus) is coming in 03:52:11.
          </div>
          <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
              <div class="card radius-10 border-start border-0 border-3 border-info">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div>
                      <p class="mb-0 text-secondary">Timer</p>
                      <h4 class="my-1 text-info">04:00</h4>
                      <p class="mb-0 font-13">+10% after 6 hours</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle  ms-auto"><i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card radius-10 border-start border-0 border-3 border-danger">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div>
                      <p class="mb-0 text-secondary">Reward per faucet</p>
                      <h4 class="my-1 text-danger">60 Tokens</h4>
                      <p class="mb-0 font-13">+10% after 8 hours</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle  ms-auto"><i class="fa fa-gift"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card radius-10 border-start border-0 border-3 border-success">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div>
                      <p class="mb-0 text-secondary">Points per claim</p>
                      <h4 class="my-1 text-success">5</h4>
                      <p class="mb-0 font-13">+5% after 6 hours</p>
                    </div>
                    <div class="widgets-icons-2 rounded-circle  ms-auto"><i class="fa fa-line-chart"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card radius-10 border-start border-0 border-3 border-warning">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div>
                      <p class="mb-0 text-secondary">Claim Limit</p>
                      <h4 class="my-1 text-warning">Unlimited</h4>
                      <p class="mb-0 font-13">Unlimited</p>
                    </div>
                    <div class="widgets-icons-2 ms-auto"><i class="fa fa-globe"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12" id="horizontalbanner">

        </div>

        <div class="col-lg-4 col-sm-12 col-md-12" id="leftBannerAd">

        </div>

        <div class="col-lg-4 col-sm-12 col-md-12" id="faucet">
          <div id="bannerAboveClaim">

          </div>
          <form method="POST" action=" {{ route( 'worker.claim_faucet' ) }} ">
            @csrf
            <div class="mb-3 captcha text-center">
                {!! Captcha::display() !!}
            </div>
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary" type="button">Claim</button>
            </div>

            <div class="col-lg-12" id="horizontalbanner">

            </div>
          </form>
        </div>

        <div class="col-lg-4 col-sm-12 col-md-12" id="RightBannerAd">
          
        </div>

      </div>
    </div>
    <!-- My faucet end -->
  </div>
  <!-- user faucet END -->
</div>
@if(session()->has('message'))
        <script>
            Swal.fire({
                title: "Good job!",
                text: "{{ session('message')}} ",
                icon: "success"
            });
        </script>
    @endif 
    
    @if(session()->has('error'))
        <script>
            Swal.fire({
                title: "Oops!",
                text: "{{ session('error')}} ",
                icon: "error"
            });
        </script>
    @endif 
@endsection