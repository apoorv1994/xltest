<div class="col-sm-12 no-padding bg-voilet">
    <div class="container bg-white wallet-panel">
        <div class="row">
            <form action="<?=BASE?>payments" method="post">
                <div class="col-xs-12 col-sm-12 padding-top-20 padding-bottom-20">
                    <div class="col-xs-12 col-sm-3 border-right" id="walletcnt">
                        <div class="col-xs-4 col-sm-4">
                            <img class="img-responsive" src="<?=BASE?>assets/img/bus.png" />
                        </div>
                        <div class="col-xs-8 col-sm-8 no-padding linehieght-30">
                            <div class="col-sm-12 fs-16">Rs. <span class="wallet-price"><?=$details->wallet_balance?></span></div>
                            <small class="col-sm-12">Your Wallet Ballance</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-9 ">
                        <div class="col-xs-12 col-sm-6 padding-top-10">
                            <input type="number" class="form-control" placeholder="Enter Amount" name="amount" required="" />
                        </div>
                        <div class="col-xs-12 col-sm-3 p-t-15">
                            <a href="" class="hidden" title="Promocode">Have a Promo Code?</a>
                        </div>
                        <div class="col-xs-12 col-sm-3 no-l-pad padding-top-10" id="walletbtn">
                            <button class="btn btn-info btn-wallet" type="submit">ADD MONEY TO WALLET</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>