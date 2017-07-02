<section id="search" class="container">
    <div class="row">
        <form action="search.php" method="get" role="form">
                <h3 class="thumb">Search for Cars</h3>
            <div class="col-sm-4 col-md-4">
                    <div class="form-group">
<!--                    	<label for="manufacturer" class="control-label">Manufacturer</label>-->
                    	<div class="">
                    		<select name="brand" id="brand" onchange="up()" class="form-control">
                                <option value="">Manufacturer</option>
                                <?php
                                $makes = new model();

                                foreach($makes->manufacturers() as $manuc){
                                    echo $manuc;
                                }
                                ?>
                            </select>
                    	</div>
                    </div>
                <div class="form-group">
<!--                    <label for="type" class="control-label">Type</label>-->
                    <div class="">
                        <select name="type" id="type" class="form-control">
                            <option value="">Type</option>
                            <option value="Sedan" >Sedan</option>
                            <option value="Coupe" >Coupe</option>
                            <option value="Sports Car" >Sports Car</option>
                            <option value="Luxury Car" >Luxury Car</option>
                            <option value="SUV" >SUV</option>
                            <option value="Van" >Van</option>
                            <option value="Truck" >Truck</option>


                        </select>
                    </div>
                </div>
                <div class="form-group">
<!--                    <label for="condition" class="control-label">Condition</label>-->
                    <div class="">
                        <select name="condition" id="condition" class="form-control">
                            <option value="">condition</option>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="pre_owned">Certified Pre Owned</option>
                            <option value="recondition">Recondition</option>
                            <option value="other">Other</option>


                        </select>
                    </div>
                </div>


            </div>
            <div class="col-sm-4 col-md-4">
                <div class="form-group">
<!--                    <label for="model" class="control-label">Model</label>-->
                    <div class="">
                        <select name="model" id="model" class="form-control">
                            <option value="">Model</option>
                            <?php


                                foreach($makes->models() as $model){
                                    echo $model;
                                }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="form-group">
<!--                    <label for="from" class="control-label">Model Year(From-To)</label>-->
                    <div class="row">
                        <div class="col-md-8">
                            <select name="from" id="from" class="form-control">
                                <option value="">Model Year(From)</option>

                                <?php
                                foreach(years::listYears() as $year){
                                    echo $year;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="to" id="to" class="form-control">
                                <option value="">To</option>
                                <?php
                                foreach(years::listYears() as $year){
                                    echo $year;
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
<!--                    <label for="transmission" class="control-label">Transmission</label>-->
                    <div class="">
                        <select name="transmission" id="transmission" class="form-control">
                            <option value="">Transmission</option>
                            <option value="Automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                            <option value="Semi Automatic">Semi Automatic</option>
                            <option value="Other">Other</option>

                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="form-group">
<!--                    <label for="from" class="control-label">Price Range Between</label>-->
                    <div class="">
                        <select name="pricefrom" id="pricefrom" class="form-control">
                            <option value="">Price Range (From)</option>
                            <option value="100000000">100000000</option>
                            <option value="50000000">50000000</option>
                            <option value="40000000">40000000</option>
                            <option value="30000000">30000000</option>
                            <option value="20000000">20000000</option>
                            <option value="10000000">10000000</option>
                            <option value="8000000">8000000</option>
                            <option value="6000000">6000000</option>
                            <option value="4000000">4000000</option>
                            <option value="2000000">2000000</option>
                            <option value="1000000">1000000</option>
                            <option value="500000">500000</option>
                            <option value="100000">100000</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <select name="priceto" id="priceto" class="form-control">
                            <option value="">To</option>
                            <option value="100000000">100000000</option>
                            <option value="50000000">50000000</option>
                            <option value="40000000">40000000</option>
                            <option value="30000000">30000000</option>
                            <option value="20000000">20000000</option>
                            <option value="10000000">10000000</option>
                            <option value="8000000">8000000</option>
                            <option value="6000000">6000000</option>
                            <option value="4000000">4000000</option>
                            <option value="2000000">2000000</option>
                            <option value="1000000">1000000</option>
                            <option value="500000">500000</option>
                            <option value="100000">100000</option>

                        </select>
                    </div>
                </div>
                <input class="form-control" type="hidden" name="token" value="<?php echo token::generate(); ?>">
                <button type="submit" class="btn btn-success submit">Search</button>


            </div>
        </form>
    </div>
</section>

