<?php session_start(); ?>

<?php include('database/connect.php'); ?>

<!DOCTYPE html>

<?php 

if(isset($_GET) && !empty($_GET)){

    $sr_id = $_GET['sr_id'];
    $pk_id = $_GET['pk_id'];

    $date = date('Y-m-d'); 
    $min_date = date("Y-m-d", strtotime($date) + 1382400);

    $sqlN = "SELECT * FROM tb_store WHERE sr_id = $sr_id";
    $resultN = $conn->query($sqlN);
    $rowN = $resultN->fetch_assoc();
 
    $sqlP = "SELECT * FROM tb_packet WHERE pk_id = $pk_id";
    $resultP = $conn->query($sqlP);
    $rowP = $resultP->fetch_assoc();

}else{

    header( "location: store.php" );

}

?>

<?php include('template-customer/head.php'); ?>

<body>

    <?php include('template-customer/top-menu.php'); ?>

    <main id="main">

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
            <div class="container mt-5 pt-4 justify-content-center" data-aos="fade-up">

                <div class="section-title">
                    <h2>ร้าน<?php echo $rowN['sr_name'] ?> แพ็คเกจ <?php echo number_format($rowP['pk_name']) ?> บาท
                    </h2>
                    <p>รายการอาหาร</p>
                </div>

                <form action="confirm.php" method="post">

                    <div class="row">

                        <?php 
                    
                        $sqlSc = "SELECT * FROM tb_category WHERE sr_id = $sr_id";
                        $resultSc = $conn->query($sqlSc);

                        $count = 1;
                    
                foreach($resultSc as $rowSc){ 
                        
                        $dish = "dish_" . $count;

                        $cg_id = $rowSc['cg_id'];

                        $sqlSf = "SELECT * FROM tb_food WHERE cg_id = $cg_id AND pk_id = $pk_id AND sr_id = $sr_id";
                        $resultSf = $conn->query($sqlSf);    
                        
                ?>

                        <div class="section-title">
                            <p class="text-center m-0 p-0"> <?php echo $rowSc['cg_name'] ?></p>
                        </div>

                        <div class="row justify-content-center">

                            <?php

                    foreach($resultSf as $rowSf) {

                    ?>

                            <div class="col-lg-3 mx-3 mb-5 pt-0">
                                <div class="box rounded" data-aos="zoom-in" data-aos-delay="100"
                                    style="height: 340px; background-color: #e6d035;">
                                    <?php

                        if ($rowSf['fd_img'] == "") { 
                            
                    ?>

                                    <img src="image/food/food.jpg" class="img-fluid rounded-circle"
                                        style="min-height: 160px; max-height: 160px; min-width: 228px; max-width: 228px;">

                                    <?php

                        } else { 
                            
                    ?>

                                    <img src="image/food/<?php echo $rowSf['fd_img'] ?>"
                                        class="img-fluid rounded-circle" style="min-height: 180px; max-height: 180px;">

                                    <?php

                        }

                    ?>

                                    <div class="card-body text-center">
                                        <label class="form-check-label fs-5 fw-bolder text-success">
                                            <?php echo $rowSf['fd_name'] ?> </label>
                                        <br>
                                        <input class="form-check-input border-2 border-danger mt-2 mb-2" type="radio"
                                            name="<?php echo $dish ?>" value="<?php echo $rowSf['fd_id'] ?>" required>
                                    </div>

                                </div>

                            </div>

                            <?php
                    
                    } 

                            $_SESSION['count'] = $count;
                            $count++;

                }
                            
                        ?>

                        </div>

                        <div class="row">

                            <div class="section-title text-center">
                                <p>กรอกข้อมูลการจอง</p>
                            </div>

                            <input type="hidden" name="sr_id" value="<?php echo $sr_id; ?>">
                            <input type="hidden" name="pk_id" value="<?php echo $pk_id; ?>">
                            <input type="hidden" name="pk_name" value="<?php echo $rowP['pk_name'] ?>">

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">รหัสบัตรประชาชน</span>
                                <input type="text" class="form-control" name="cm_id"
                                    onKeyUp="if(this.value*1!=this.value) this.value='' ;" placeholder="รหัสบัตรประชาชน"
                                    minlength="13" maxlength="13" required>
                            </div>

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">ชื่อ - นามสกุล</span>
                                <input type="text" class="form-control" name="cm_name"
                                    onKeyUp="if(this.value*1==this.value) this.value='' ;" placeholder="ชื่อ-สกุล"
                                    minlength="2" maxlength="30" required>
                            </div>

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">อีเมล</span>
                                <input type="email" class="form-control" name="cm_email" placeholder="Email"
                                    maxlength="50" required>
                            </div>

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">เบอร์ติดต่อ</span>
                                <input type="text" class="form-control" name="cm_phone"
                                    onKeyUp="if(this.value*1!=this.value) this.value='' ;if(this.value*1 >= 9999999999) this.value='' ;"
                                    placeholder="เบอร์ติดต่อ" minlength="10" maxlength="10" required>
                            </div>

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">Line ID (ถ้ามี)</span>
                                <input type="text" class="form-control" name="cm_line" placeholder="Line (ID)"
                                    maxlength="30">
                            </div>

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">จำนวนโต๊ะ</span>
                                <input type="text" class="form-control" name="ord_table"
                                    onKeyUp="if( this.value*1 != this.value ) this.value = '' ; if(this.value*1 >= 500) this.value = '' ;"
                                    value="10" min="10" max="1000" required>
                            </div>

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">วันที่จัดงาน</span>
                                <input type="date" class="form-control" name="ord_date" value="<?php echo $min_date; ?>"
                                    min="<?php echo $min_date; ?>" required>
                            </div>

                            <div class="input-group mb-4 w-50">
                                <span class="input-group-text">เวลาจัดงาน</span>
                                <input type="time" class="form-control" name="ord_time" required>
                            </div>

                            <div class="input-group mb-4 w-100">
                                <span class="input-group-text">สถานที่จัดงาน</span>
                                <textarea type="text" class="form-control" name="ord_address" rows="5" minlength="2"
                                    maxlength="200" required></textarea>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-success col-2 mx-auto mt-3 mb-3">สั่งจอง</button>

                </form>

            </div>
        </section><!-- End Why Us Section -->

    </main><!-- End #main -->

    <?php include('template-customer/footer.php'); ?>

    <?php include('template-customer/script.php'); ?>

</body>

</html>