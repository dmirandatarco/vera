<div wire:ignore.self >
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" wire:ignore.self>
        <div class="offcanvas-body" wire:ignore.self>
            <div aria-multiselectable="true" class="accordion accordion-dark" id="accordion2" role="tablist" wire:ignore.self>
                <div class="card mb-0">
                    <div class="card-header" id="headingOne2" role="tab">
                        <a aria-controls="collapseOne2" aria-expanded="true" data-bs-toggle="collapse" href="#collapseOne2"><i class="fe fe-user me-2"></i>Datos Generales</a>
                    </div>
                    <div aria-labelledby="headingOne2" class="collapse show" data-bs-parent="#accordion2" id="collapseOne2" role="tabpanel">
                        <div class="card-body">
                            <div class="main-contact-item">
                                <div class="main-img-user"><img alt="avatar" src="https://spruko.com/demo/nowa/dist/assets/images/faces/2.jpg"></div>
                                <div class="main-contact-body">
                                    <h6>Nombre del Asesor:</h6>
                                    <h6>{{$ventaId}}</h6>
                                    <span class="me-2">
                                        <i class="far fa-calendar-check"></i>
                                        11/11/2023
                                    </span>
                                    <span>
                                        <i class="far fa-clock"></i>
                                        13:08
                                    </span>
                                </div>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-xs-6">
                                        <div class="row border-end bd-xs-e-0">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 d-flex align-items-start p-3 gap-4">
                                                <i class="fa fa-archive"></i>
                                                <h6 class="mb-2 tx-12">Profit Gain</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-xs-6">
                                        <div class="row border-end bd-xs-e-0">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 d-flex align-items-start p-3 gap-4">
                                                <i class="fa fa-sitemap"></i>
                                                <h6 class="mb-2 tx-12">Profit Gain</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 px-3">
                                        <div class="row border-end bd-xs-e-0">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 d-flex gap-4">
                                                <i class="fa fa-user-secret"></i>
                                                <h6 class="mb-2 tx-12">Cliente Nombre y Apellido</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- accordion -->
        </div>
    </div>
</div>
