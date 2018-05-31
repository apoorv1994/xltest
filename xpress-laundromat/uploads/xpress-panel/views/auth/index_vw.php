<link rel="stylesheet" href="<?=BASE?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" />
<!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg no-padding">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <div class="col-sm-12 no-padding home-header">
                <div class="container-fluid">
                    <div class="head-text col-sm-8">
                        <h3 class="col-sm-12">Make your life <span class="bigger">better</span></h3>
                        <p class="col-sm-8">We are a team of individuals who want to make your life better without you having to stress about the mundane chores of laundering clothes.</p>
                        <p class="col-sm-8">Xpress Laundromat is your One Stop Laundering Solution. So, with our help you can Kiss away all the Troubles of Laundering, and Handling your clothes. Just Sign Up, and be Good to Go!</p>

                    </div>
                    <div class="col-sm-3 signin">
                        <p class="col-sm-12"><span class="big">Log In</span> to book your schedule</p>
                        <form id="loginFrm">
                            <div class="col-sm-12">
                                <small id="main_log_err" class="col-sm-12"></small>
                                <div class="col-sm-6 no-padding"><input type="email" class="form-control" name="email" placeholder="Email ID"></div>
                                <div class="col-sm-6 no-padding"><input type="password" class="form-control" name="password" placeholder="Password"></div>
                                <div class="col-sm-12 no-padding margin-top-10">
                                    <button type="button" class="form-control loginbtn" id="loginbtn" name="Login">LOG IN <i class="fa fa-arrow-right pull-right" id="loader_log"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12 margin-top-10">
                            New User? <a href="javascript:void(0)" id="showsignup">Sign Up Now</a>
                        </div>
                        <div class="col-sm-12 margin-top-10">
                            <a href="<?=BASE?>auth/forgot-password" >Forgot Password</a>
                        </div>
                    </div>
                    <!--signup -->
                    <div class="col-xs-12 col-sm-3 signup">
                        <p class="col-xs-12 col-sm-12"><span class="big">SIGNUP</span> to book your schedule</p>
                        <form id="signupFrm" >
                        <div class="col-xs-12 col-sm-12">
                            <div class="col-sm-12 no-padding">
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <input type="text" class="form-control" name="firstname" placeholder="First Name*">
                                    <small class="col-xs-12 col-sm-12 no-padding" id="firstname_err"></small>
                                </div>
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <input type="text" class="form-control" name="lastname" placeholder="Last Name*">
                                    <small class="col-xs-12 col-sm-12 no-padding" id="lastname_err"></small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding">
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <input type="text" class="form-control" id="dob" name="dob" placeholder="Date Of Birth*">
                                    <small class="col-xs-12 col-sm-12 no-padding" id="dob_err"></small>
                                </div>
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <select class="form-control select2" name="gender">
                                    <option value="">Gender*</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    </select>
                                    <small class="col-xs-12 col-sm-12 no-padding" id="gender_err"></small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding">
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <input type="text" class="form-control" name="rollnumber" placeholder="Roll Number*">
                                    <small class="col-sm-12 no-padding" id="rollnumber_err"></small>
                                </div>
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <input type="text" class="form-control" maxlength="10" name="phonenumber" placeholder="Phone Number*">
                                    <small class="col-xs-12 col-sm-12 no-padding" id="phonenumber_err"></small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding margin-top-10">
                                <select class="form-control select2" id="college_id" name="college_id">
                                    <option value="">College Name*</option>
                                    <?php foreach($colleges as $college){?>
                                    <option value="<?=$college->id?>"><?=$college->college_name?></option>
                                    <?php }?>
                                </select>
                                <small class="col-xs-12 col-sm-12" id="college_id_err"></small>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding margin-top-10">
                                <select class="form-control select2" id="hostel_id" name="hostel_id">
                                    <option value="">Hostel Block*</option>
                                </select>
                                <small class="col-xs-12 col-sm-12" id="hostel_id_err"></small>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding margin-top-10">
                                <input type="text" class="form-control" name="roomnumber" placeholder="Room Number*">
                                <small class="col-xs-12 col-sm-12 no-padding" id="roomnumber_err"></small>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding margin-top-10">
                            <div class="col-xs-6 col-sm-6 no-padding ">
                                <input type="text" class="form-control" name="emailprefix" id="emailprefix" placeholder="Collage Email*">
                                <input type="hidden" class="form-control" name="emailid" id="emailid">
                            </div>
                            <div class="col-xs-6 col-sm-6 no-padding">
                                <input type="text" class="form-control" style="color: rgba(98, 98, 98, 1)" id="emailsuffix" name="emailsuffix" placeholder="Select College First*">
                            </div>
                                <small class="col-xs-12 col-sm-12 no-padding" id="emailid_err"></small>
                            </div>
                            <div class="col-sm-12 no-padding">
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <input type="password" class="form-control" name="password" placeholder="Password*">
                                    <small class="col-xs-12 col-sm-12 no-padding" id="password_err"></small>
                                </div>
                                <div class="col-xs-12 col-sm-6 no-padding margin-top-10">
                                    <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password*">
                                    <small class="col-xs-12 col-sm-12 no-padding" id="cpassword_err"></small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding margin-top-10">
                                <input type="checkbox" name="terms" value="1"> I agree to the Xpressomat <a href="<?=BASE?>terms">Terms of Service</a>*
                                <small class="col-xs-12 col-sm-12 no-padding" id="terms_err"></small>
                            </div>
                            <div class="col-xs-12 col-sm-12 no-padding margin-top-10">
                                <button type="button" class="form-control signupbtn" id="signupbtn" name="signup">SIGN UP <i class="fa fa-arrow-right pull-right" id="loader"></i></button>
                                <small id="main_err"></small>
                            </div>
                        </div>
                        </form>
                        <div class="col-xs-12 col-sm-12 margin-top-10">
                            Existing User? <a href="javascript:void(0)" id="showlogin">Login Now</a>
                        </div>
                    </div>
                </div>
                <img src="<?=BASE?>assets/img/banner1.png" class="img-responsive col-sm-12 no-padding" >
            </div>
            <div class="col-xs-12 col-sm-12 no-padding">
                <img src="<?=BASE?>assets/img/banner2.png" class="img-responsive col-sm-12 no-padding" >
                <div class="col-xs-12 col-sm-5 pull-right banner2-text">
                    <h3 class="col-xs-12 col-sm-12"><span class="bigger">Services for you</span> </h3>
                    <p class="col-xs-12 col-sm-12"><b>Redefining and redesigning laundering.</b></p>
                    <p class="col-xs-12 col-sm-12">
                        <b>Why waste a weekend over Clothes when we can easily take care of it all? </b></p>
                    <p class="col-xs-12 col-sm-12">Let us clean your Mess. With our Quick and Affordable Service,right from your doorstep, take your days out, and do something better.
                    </p>
                    <p class="col-xs-12 col-sm-12"> One stop solution to all your laundry hassles with service right at your doorstep.

Give a Regular High Quality wash to All your clothes to keep them fresh, a Spa like pampering by choosing our Premium Wash or Bespoke Finish by Dry and what not!!!! So let’s laundry then, sire ;) </p>
            
                    
                </div>
            </div>
             <div class="col-xs-12 col-sm-12 testimonial">
                <div class="container-fluid ">
                    
                <div class="col-sm-12">
                    <div class="col-md-12">
                       <div class="col-xs-12 col-sm-3  " >
                            <div class="col-xs-12 col-sm-12  service-box"> 
                                <h3 style="color:rgb(0,194,220)"  class="text-center">BULK WASHING</h3>
                                <img src="<?=BASE?>assets/img/bulk.png" >
                                <div style="padding: 20px">
                                    Throw all of Your Weekly/Monthly Load of Dirty Clothes to us, and Let us do the rest. The rates are the cheapest with this option. Unit to Measure: Kilograms (KG)
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-xs-12 col-sm-3 ">
                            <div class="col-xs-12 col-sm-12 service-box "> 
                                <h3 style="color:rgb(0,194,220)"  class="text-center">FEW AT A TIME</h3>
                                <img src="<?=BASE?>assets/img/few.jpg">

                                <div style="padding: 20px">
                                    If you wish to get a few clothes cleaned, and Ironed by us, choose this service. You can also choose to get your clothes only Ironed. A fixed amount per cloth will apply.

                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 ">
                            <div class="col-xs-12 col-sm-12 service-box "> 
                                <h3 style="color:rgb(0,194,220)"  class="text-center">PREMIUM WASH</h3>
                                <img src="<?=BASE?>assets/img/premium.jpg">

                                <div style="padding: 20px">
                                    For your special Outfits, and Premium Clothes, which you would want to be take extra care of. Simply, fill in the details below, and you will be Good to Go.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 ">
                            <div class="col-xs-12 col-sm-12 service-box "> 
                                <h3 style="color:rgb(0,194,220)"  class="text-center">DRY CLEANING</h3>
                                <img src="<?=BASE?>assets/img/dryclean.jpg">

                                <div style="padding: 20px">
                                    For the Best Dry Cleaning Services, at the Best Rates, Pick this one right now. Our Pilot will soon Pick your Parcel, and you will have the Dry Cleaned Clothes, at the Quickest.
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    </div>
                    
                </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 bg-white banner3">
                <div class="container-fluid">
                <div class="col-sm-4 padding-top-20">
                    <div class="col-sm-12">
                        <p>
                        <span class="bigger2">Why us?</span> 
                    </p>
                    <p>Specially Designed for Students, our Plans offer the Best Saving Options, for your Money. For your Time. Along with the Best Quality, you can ever get
                    </p>
        
                    </div>
                    <div class="col-sm-12">
                        <p class="color-blue">
                           Eco-Friendly
                        </p>
                        <p>Optimized Machinery - Consume Less, Deliver More!<br>
                            Quality Detergents - No Contamination!</p>
                    </div>
                    <div class="col-sm-12">
                        <p class="color-blue">
                           Affordable
                        </p>
                        <p>We have kept the Interface, simple, in order to promote Ease of Access. Just do it, in a Few Clicks. Simple, right?
</p>
                    </div>
                </div>
                <div class="col-sm-4">
                     <img src="<?=BASE?>assets/img/wash.png" class="img-responsive" >
                </div>
                <div class="col-sm-4 padding-top-20">
                    <div class="col-sm-12">
                        <p class="color-blue">
                           FAST DELIVERY
                        </p>
                        <p>Usually we<b> Deliver back within 24 Hours</b>
                            <br>
                            In Case of <b>Emergencies, cut it short to 6 Hours</b></p>
                    </div>
                    <div class="col-sm-12">
                        <p class="color-blue">
                           Quality
                        </p>
                        <p><b>Our Detergent Mix </b>makes every cloth, as good as New

                        </p><p>We pay<b> Personal Attention </b>to every Cloth, which reaches us.
</p>
                    </div>
                    <div class="col-sm-12">
                        <p class="color-blue">
                          Your Time, Your Ease:

                        </p>
                        <p>Busy Tonight, Tomorrow, and Even after that? No problem, Just Pick a Time, according to your convenience. We’ll be there. Always.</p>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 testimonial">
                <div class="container-fluid text-center">
                    <h3 class="col-sm-12 bigger2 margin-bottom-60">Testimonials</h3>
                    <div class="col-sm-12">
                        <div class="col-md-8 col-md-offset-2">
<!--                <div class="quote"><i class="fa fa-quote-left fa-4x"></i></div>-->
				<div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
				  <!-- Carousel indicators -->
                  <ol class="carousel-indicators">
				    <li data-target="#fade-quote-carousel" data-slide-to="0"></li>
				    <li data-target="#fade-quote-carousel" data-slide-to="1"></li>
				    <li data-target="#fade-quote-carousel" data-slide-to="2" class="active"></li>
                    <li data-target="#fade-quote-carousel" data-slide-to="3"></li>
                    <li data-target="#fade-quote-carousel" data-slide-to="4"></li>
				  </ol>
				  <!-- Carousel items -->
				  <div class="carousel-inner">
				    <div class="item">
                        <div class="profile-circle" style="background-color: rgba(0,0,0,.2);"></div>
				    	<blockquote>
				    		<p>Xpresslaundromat is a really good laundry service which has helped improve hostel life for me. It

has performed quite well in my University despite the odds. The washing, drying and ironing is done

at an affordable price and hence is very economical especially for students. The affordability and

ease of using the service, make it worthy of applause.</p>
				    	</blockquote>
                        <strong>-Vasa Jaishanth, Convenor, Campus Development Committee (2016-17), NLUO, Cuttack.</strong>
				    </div>
				    <div class="item">
                        <div class="profile-circle" style="background-color: rgba(77,5,51,.2);"></div>
				    	<blockquote>
				    		<p>Perfect startup and nice service.”</p>
				    	</blockquote>
                        <strong>- S.V.DHEERAJ KUMAR 2014 EE Batch IIT Indore</strong>
				    </div>
				    <div class="active item">
                        <div class="profile-circle" style="background-color: rgba(145,169,216,.2);"></div>
				    	<blockquote>
				    		<p>Great startup. Keep up the good work. I am a user of this service. Really great to have a sure

way to clean my clothes without stress.</p>
				    	</blockquote>
                        <strong>- Sumesh Kaul 2014 EE Batch IIT Indore</strong>
				    </div>
                    <div class="item">
                        <div class="profile-circle" style="background-color: rgba(77,5,51,.2);"></div>
    			    	<blockquote>
				    		<p>Xpress laundromat is quite good and I wanna use it.</p>
				    	</blockquote>
                         <strong>- Piyush Singh 2016 CE Batch IIT Indore</strong>
				    </div>
                                     
                    <div class="item">
                        <div class="profile-circle" style="background-color: rgba(77,5,51,.2);"></div>
    			    	<blockquote>
				    		<p>As an engineer, I don&#39;t like to wash my clothes. Thanks to laundromat now my cloths don&#39;t smell bad</p>
				    	</blockquote>
                        <strong>- Dharmendra Kumar 2013 EE Batch, IIT Indore</strong>
				    </div>
				  </div>
				</div>
			</div>
<!--                        <p class="col-sm-offset-3 col-sm-6">
                            <b>Perfect startup and nice service.</b><br>S.V.DHEERAJ KUMAR 2014 EE Batch IIT Indore
                        </p>
                        <p class="col-sm-1"><img src="<?=BASE?>assets/img/profiles/1.jpg" class="img-circle img-thumbnail"></p>-->
                    </div>
                </div>
            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
          <script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" ></script>
          <script src="<?=BASE?>assets/plugins/moment/moment.min.js"></script>
          <script>
              $(document).ready(function(){
                  
                  $('#emailprefix,#emailsuffix').keyup(function(){
                      $('#emailid').val($(this).val()+$('#emailsuffix').val());
                  })
                  $('#emailprefix,#emailsuffix').blur(function(){
                      $('#emailid').val($(this).val()+$('#emailsuffix').val());
                  })
                  $('#showsignup').click(function(){
                      $('.signin').hide('fade');
                      $('.signup').show('fade')
                  });
                  $('#showlogin').click(function(){
                      $('.signin').show('fade');
                      $('.signup').hide('fade')
                  });
                  $('#dob').datepicker({
                      format: 'dd-mm-yyyy',
                      endDate: '-3650d',
                      autoclose:true
                  });
                  $('.select2').select2();
                  
                  $('#college_id').change(function(){
                      $('#emailprefix').val('');
                      $('#emailid').val('');
                        var id = $(this).val();
                        var url = '<?=BASE?>auth/get-hostel/'+id;
                        $.get(url,function(success){
                            var opt ='';
                            var res = JSON.parse(success);
                            if(res.status)
                            {
                                var len = res.data.length;
                                for(var i=0;i<len;i++)
                                {
                                    opt+='<option value="'+res.data[i].id+'">'+res.data[i].hostel_name+'</option>';
                                }
                                $('#hostel_id').html(opt);
                                if(res.suffix){
                                    if(id==3){
                                       // $('#emailsuffix').removeAttr('readonly');
                                    }
                                    else{
                                        //$('#emailsuffix').prop('readonly',true);
                                    }
                                $('#emailsuffix').val(res.suffix);
                                }else{
                                    $('#emailsuffix').val('');
                                }
                            }
                            else{
                                $('#hostel_id').html('<option value="">Select Hostel*</option>');
                                $('.select2').select2();
                                $('#emailsuffix').val('');
                            }
                      })
                  });
                  //for registration 
                  $('.signupbtn').click(function(){
                      $('#loader').addClass('fa-spin fa-spinner');
                      $('#main_err').html('');
                      var url = '<?=BASE?>auth/signup';
                      var data = $('#signupFrm').serialize();
                      $.post(url,data,function(success){
                            var res = JSON.parse(success);
                            if(res.status)
                            {
                                $('#loader').removeClass('fa-spin fa-spinner');
                                $('#loader').addClass('fa-arrow-right');
                                $('#main_err').html('<span class="success">Registered successfully</span>');
                                window.location.href = '<?=BASE?>auth/verify-email';
                            }
                            else
                            {
                                var error = res.error;
                                $.each( error, function( i, val ) 
                                {
                                    $('#'+i).html(val);
                                });
                                $('#loader').removeClass('fa-spin fa-spinner');
                                $('#loader').addClass('fa-arrow-right');
                                $('#main_err').html('<span class="err">Error occured.</span>');
                            }
                      })
                  });
                  //for login
                  $('.loginbtn').click(function(){
                      $('#loader_log').addClass('fa-spin fa-spinner');
                      $('#main_log_err').html('');
                      var url = '<?=BASE?>auth/login';
                      var data = $('#loginFrm').serialize();
                      console.log(data);
                      $.post(url,data,function(success){
                            var res = JSON.parse(success);
                            if(res.status)
                            {
                                $('#loader_log').removeClass('fa-spin fa-spinner');
                                $('#loader_log').addClass('fa-arrow-right');
                                $('#main_log_err').html('<span class="success">Login successfully</span>');
                                window.location.href = res.rdir;
                            }
                            else
                            {
                                var error = res.error;
                                $('#loader_log').removeClass('fa-spin fa-spinner');
                                $('#loader_log').addClass('fa-arrow-right');
                                $('#main_log_err').html('<span class="err">'+error+'</span>');
                            }
                      })
                  });
              })
              </script>