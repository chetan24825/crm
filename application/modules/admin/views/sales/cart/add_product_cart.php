<div class="table">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="tireFields">
            <thead>

            <tr style="background-color: #ECEEF1">
                <th style="width: 15px">#</th>
                <th class="col-sm-2"><?= lang('product') ?></th>  
                <th class="col-md-4" width="20%" style="width:20%"><?= lang('description') ?></th>              
                <th class=""><?= lang('renewal_date') ?></th>
                <th class=""><?= lang('renewal_period') ?></th>
                <th class=""><?= lang('rate') ?></th>
                <th class=""><?= lang('qty') ?></th>
                <th class=""><?= lang('amount') ?></th>
                <th class=""> </th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; if(!empty($this->cart->contents())) { foreach ($this->cart->contents() as $cart) { ?>
                <tr>
                    <td>
                        <div class="form-group form-group-bottom">
                            <?php echo $i ?>
                        </div>
                    </td>
                    <td>
                        <div class="form-group form-group-bottom p_div">
                            <select class="form-control select2" style="width: 100%; z-index: 9999" onchange="get_product_id(this)" id="<?php echo $cart['rowid']?>">
                                <option value=""><?= lang('please_select') ?>..</option>
                                <?php if(!empty($products)){ foreach ($products as $key => $product){ ?>
                                    <optgroup label="<?php echo $key?>">
                                        <?php foreach ($product as $item){ ?>
                                            <option value="<?php echo $item->id  ?>" <?php echo $cart['id'] === $item->id ?'selected':''  ?>> <?php echo $item->name ?>
                                            </option>
                                        <?php } ?>
                                    </optgroup>
                                <?php }; } ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group form-group-bottom">
                            <?php if($cart['type']){ ?>
                                <?php echo $cart['description']?>
                            <?php }else{ ?>
                                <input class="form-control" type="text" name="description" onblur ="updateItem(this);" id="<?php echo 'des'.$cart['rowid'] ?>" value="<?php echo $cart['description']?>">
                            <?php } ?>
                        </div>
                    </td>
                    <td>
                        <?php $renewaldate = date("Y/m/d"); ?>
                        <input name="renewaldate" class="form-control renewaldate" id="<?php echo 'red'.$cart['rowid'] ?>" onchange="updateItem(this);" type="text" data-date-format="yyyy/mm/dd" value="<?php echo $cart['renewal_date'] ?>">
                    </td>
                    <td>
                        <select class="form-control" name="renewalperiod" id="<?php echo 'rep'.$cart['rowid'] ?>" onchange ="updateItem(this);">
                            <option value="monthly" <?php echo $cart['renewal_period'] === 'monthly' ?'selected':''  ?>>Monthly</option>
                            <option value="yearly" <?php echo $cart['renewal_period'] === 'yearly' ?'selected':''  ?>>Yearly</option>
                        </select>
                    </td>
                    <td>
                        <div class="form-group form-group-bottom">
                            <input class="form-control" type="text" name="price" value="<?php echo $cart['price'] ?>" onblur ="updateItem(this);" id="<?php echo 'prc'.$cart['rowid'] ?>">
                        </div>
                    </td>                    
                    <td>
                        <div class="form-group form-group-bottom">
                            <input class="form-control" type="text" name="qty" onblur ="updateItem(this);" value="<?php echo $cart['qty'] ?>" id="<?php echo 'qty'.$cart['rowid'] ?>">
                        </div>
                    </td>
                    <td>
                        <div class="form-group form-group-bottom">
                            <input class="form-control" type="text" readonly value="<?php echo $cart['subtotal'] ?>">
                        </div>
                    </td>

                    <input type="hidden" name="product_code" value="<?php echo $cart['id']  ?>" id="<?php echo 'pid'.$cart['rowid'] ?>">

                    <td>
                        <a href="javascript:void(0)" id="<?php echo $cart['rowid'] ?>" onclick="removeItem(this);"  class="remTire" style="color: red"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>

                </tr>

                <?php $i++; };} ?>

            <tr>
                <td>
                    <div class="form-group form-group-bottom">

                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom p_div">
                        <select class="form-control select2" style="width: 100%; z-index: 9999" onchange="get_product_id(this)" id="">
                            <option value=""><?= lang('please_select') ?>..</option>
                            <?php if(!empty($products)){ foreach ($products as $key => $product){ ?>
                                <optgroup label="<?php echo $key?>">
                                    <?php foreach ($product as $item){ ?>
                                        <option value="<?php echo $item->id  ?>" >
                                            <?php echo $item->name ?>
                                        </option>
                                    <?php } ?>
                                </optgroup>
                            <?php }; } ?>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text">
                    </div>
                </td>
                <td>
                    <?php $renewaldate = date("Y/m/d"); ?>
                    <input name="renewaldate" class="form-control renewaldate" id="renewaldate1" type="text" data-date-format="yyyy/mm/dd" value="<?php echo $renewaldate ?>">
                </td>
                <td>
                    <select class="form-control select2" name="renewalperiod" id="renewalperiod1">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </td>
                <td>
                    <input class="form-control" type="text">
                </td>
                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text">
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text">
                    </div>
                </td>

                <td>
                    <div class="form-group form-group-bottom">
                        <input class="form-control" type="text" readonly>
                    </div>
                </td>


            </tr>

            </tbody>
        </table>
    </div>

    <table class="table table-hover">
        <thead>

        <tr style="border-bottom: solid 1px #ccc">
            <th style="width: 15px"></th>
            <th class="col-sm-2"></th>
            <th class="col-sm-5"></th>
            <th class=""></th>
            <th class=""></th>
            <th style="width: 230px"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="5" style="text-align: right">
                <?= lang('total') ?>
            </td>

            <td style="text-align: right; padding-right: 30px">
                <?php echo $this->cart->total(); ?>
            </td>

        </tr>


        <?php if ($this->session->userdata('type') != 'quotation') { ?>

            <?php $total_tax = 0.00 ?>
            <?php if (!empty($this->cart->contents())): foreach ($this->cart->contents() as $item) : ?>
                <?php $total_tax += $item['tax'] ?>
            <?php endforeach; endif ?>
            <?php if(!empty($gst_tax)){ ?>
            <tr>
                <td colspan="5" style="text-align: right">
                    GST %
                </td>
                <td style="text-align: right; padding-right: 30px">
                    <select name="gst_tax" class="form-control select2" style="width: 100%;" onchange="get_gstTaxCalculate(this)" id="gst_tax">
                        <option value=""><?= lang('please_select') ?>..</option>
                        <?php foreach ($gst_tax as $key => $tax){ ?>
                                    <option value="<?php echo $tax->rate  ?>" <?php echo $this->session->userdata('gst') == $tax->rate ?'selected':''  ?>>
                                        <?php echo $tax->rate ?>
                                    </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <?php if(!empty($igst_tax)){ ?>
            <tr>
                <td colspan="5" style="text-align: right">
                    IGST %
                </td>
                <td style="text-align: right; padding-right: 30px">
                    <select name="igst_tax" class="form-control select2" style="width: 100%;" onchange="get_igstTaxCalculate(this)" id="igst_tax">
                        <option value=""><?= lang('please_select') ?>..</option>
                        <?php  foreach ($igst_tax as $key => $tax){ ?>
                                <option value="<?php echo $tax->rate  ?>" <?php echo $this->session->userdata('igst') == $tax->rate ?'selected':''  ?>>
                                    <?php echo $tax->rate ?>
                                </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <?php if(!empty($cgst_tax)){ ?>
            <tr>
                <td colspan="5" style="text-align: right">
                    CGST %
                </td>
                <td style="text-align: right; padding-right: 30px">
                    <select name="cgst_tax" class="form-control select2" style="width: 100%;" onchange="get_cgstTaxCalculate(this)" id="cgst_tax">
                        <option value=""><?= lang('please_select') ?>..</option>
                        <?php foreach ($cgst_tax as $key => $tax){ ?>
                            <option value="<?php echo $tax->rate  ?>" <?php echo $this->session->userdata('cgst') == $tax->rate ? 'selected':''  ?>>
                                <?php echo $tax->rate ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <?php if(!empty($sgst_tax)){ ?>
            <tr>
                <td colspan="5" style="text-align: right">
                    SGST %
                </td>
                <td style="text-align: right; padding-right: 30px">
                    <select name="sgst_tax" class="form-control select2" style="width: 100%;" onchange="get_sgstTaxCalculate(this)" id="sgst_tax">
                        <option value=""><?= lang('please_select') ?>..</option>
                        <?php foreach ($sgst_tax as $key => $tax){ ?>
                            <option value="<?php echo $tax->rate  ?>" <?php echo $this->session->userdata('sgst') == $tax->rate ?'selected':''  ?>>
                                <?php echo $tax->rate ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="5" style="text-align: right">
                    <?= lang('discount') ?> %
                </td>

                <td style="text-align: right; padding-right: 30px">
                    <input type="" class="form-control" style="text-align: right" onblur="order_discount(this)" value="<?php echo $this->session->userdata('discount');?>" name="discount">
                </td>

            </tr>
        <?php } ?>
        <tr>
            <td colspan="5" style="text-align: right; font-weight: bold">
                <?= lang('grand_total') ?>
            </td>
            <?php
                $gtotal =  $this->cart->total(); 
                $gst = $this->session->userdata('gst');
                $gst_amount = ($gtotal * $gst)/100; 
                $igst = $this->session->userdata('igst');
                $igst_amount = ($gtotal * $igst)/100; 
                $cgst = $this->session->userdata('cgst');
                $cgst_amount = ($gtotal * $cgst)/100; 
                $sgst = $this->session->userdata('sgst');
                $sgst_amount = ($gtotal * $sgst)/100;                  
                $discount = $this->session->userdata('discount');
                $discount_amount = ($gtotal * $discount)/100;          
                $result = $gtotal + $total_tax - $discount_amount;
                $grand_total = $result + $product_tax + $product_gst_tax + $gst_amount + $igst_amount + $cgst_amount + $sgst_amount;
            ?>

            <td style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px">
                <span id="grand_total"><?php echo get_option('default_currency').' '.$this->localization->currencyFormat($grand_total); ?></span>
            </td>

        </tr>
        </tbody>
    </table>
</div>