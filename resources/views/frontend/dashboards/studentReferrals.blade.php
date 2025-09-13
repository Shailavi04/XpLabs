@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Referrals</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Referrals</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="content">
    <div class="container">
        <!-- profile box -->
        @include('frontend.dashboards.profileBox')

        <!-- profile box -->
        <div class="row">
            <!-- sidebar -->

            @include('frontend.dashboards.sidebar')
            <!-- sidebar -->
            <div class="col-lg-9">
                <div class="page-title d-flex align-items-center justify-content-between">
                    <h5>Referrals</h5>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="student-info bg-skyblue-transparent referral-card border-0">
                            <div class="d-flex align-items-center">
                                <div class="referral-icon bg-skyblue me-3">
                                    <img src="assets/img/icon/dollar-circle.svg" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-1 text-gray-5 fw-normal">Net Earnings</h6>
                                    <span class="fs-20 fw-semibold mb-1 d-block text-skyblue">$12,000</span>
                                    <p class="fs-13">Earning this month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="student-info border-0 bg-secondary-transparent referral-card">
                            <div class="d-flex align-items-center">
                                <div class="referral-icon bg-secondary me-3">
                                    <img src="assets/img/icon/wallet.svg" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-1 text-gray-5 fw-normal">Balance</h6>
                                    <span class="fs-20 fw-semibold mb-1 d-block text-secondary">$15,000</span>
                                    <p class="fs-13">In the Wallet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="student-info border-0 bg-info-transparent referral-card">
                            <div class="d-flex align-items-center">
                                <div class="referral-icon bg-info me-3">
                                    <img src="assets/img/icon/wallet.svg" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-1 text-gray-5 fw-normal">No of Referrals</h6>
                                    <span class="fs-20 fw-semibold mb-1 d-block text-info">10</span>
                                    <p class="fs-13">In this month</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <h5 class="mb-3 fs-18">Your Referral Link</h5>
                                <p class="mb-2">You can earn easily money by copy and share</p>
                                <div class="mb-3">
                                    <input type="text" class="form-control" value="https://dreamslmscourse.com/refer/?refid=345re667877k9">
                                </div>
                                <a href="javascript:void(0);" class="btn btn-secondary rounded-pill">Copy link</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <h5 class="mb-3 fs-18">Withdraw Money</h5>
                                <ul class="mb-4">
                                    <li class="mb-2">
                                        Withdraw securely to your bank account.
                                    </li>
                                    <li>
                                        Commision is $25 per transaction under $10,000
                                    </li>
                                </ul>
                                <a href="javascript:void(0);" class="btn btn-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#withdraw_request">Withdraw Money</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive custom-table">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Referred ID</th>
                                <th>Referrals</th>
                                <th>URL</th>
                                <th></th>
                                <th>Visits</th>
                                <th>Total Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF010</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-01.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">Thompson Hicks</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br> refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>10</td>
                                <td>$160</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF009</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-06.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">Jennifer Tovar</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>08</td>
                                <td>$180</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF008</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-09.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">James Schulte</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>12</td>
                                <td>$200</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF007</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-20.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">Kristy Cardona</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>17</td>
                                <td>$220</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF006</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-27.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">William Aragon</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>09</td>
                                <td>$170</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF005</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-30.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">Shirley Lis</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>15</td>
                                <td>$150</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF004</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-17.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">John Brewer</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>13</td>
                                <td>$130</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF003</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-37.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">Doris Hughes</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>17</td>
                                <td>$190</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF002</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-04.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">Sarah Martinez</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>08</td>
                                <td>$140</td>
                            </tr>
                            <tr>
                                <td><a href="javascript:void(0);" class="text-primary">#REF001</a></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="instructor-details.html" class="avatar avatar-md avatar-rounded flex-shrink-0 me-2">
                                            <img src="assets/img/user/user-18.jpg" alt="">
                                        </a>
                                        <a href="instructor-details.html">
                                            <p class="fs-14">Sarah Martinez</p>
                                        </a>
                                    </div>
                                </td>
                                <td>$1https://dreamslmscourse.com/reffer/? <br>refid=345re667877k960</td>
                                <td><a href="#" class="action-icon"><i class="isax isax-document-copy4"></i></a></td>
                                <td>11</td>
                                <td>$110</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /pagination -->
                <div class="row align-items-center mt-3">
                    <div class="col-md-2">
                        <p class="pagination-text">Page 1 of 2</p>
                    </div>
                    <div class="col-md-10">
                        <ul class="pagination lms-page justify-content-center justify-content-md-end mt-2 mt-md-0">
                            <li class="page-item prev">
                                <a class="page-link" href="javascript:void(0)" tabindex="-1"><i class="fas fa-angle-left"></i></a>
                            </li>
                            <li class="page-item first-page active">
                                <a class="page-link" href="javascript:void(0)">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">3</a>
                            </li>
                            <li class="page-item next">
                                <a class="page-link" href="javascript:void(0)"><i class="fas fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /pagination -->
            </div>
        </div>
    </div>
</div>


@endsection