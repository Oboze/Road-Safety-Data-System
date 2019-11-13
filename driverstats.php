<?php 

session_start();
//Checking User Logged or Not
if(empty($_SESSION['user'])){
 header('location:index.php');
}
//Restrict admin or Moderator to Access user.php page
if($_SESSION['user']['role']=='admin'){
 header('location:admin.php');
}
if($_SESSION['user']['role']=='moderator'){
 header('location:moderator.php');
}
include 'header.php';
include 'config.php';

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Statistics and Reports
        <!--<small>Optional description</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

        <?php
      // statistical queries

      // find total number of driver in the system
     $query="SELECT Count(Driver.DriverID) AS Drivers from Driver";
     $stmt=$con->prepare($query);
     $stmt->execute();

     $totalDrivers=$stmt->fetch(PDO::FETCH_ASSOC);

      // find Drivers in the system without an offence record
      $query="SELECT Count(Driver.DriverID) AS Good_Drivers From Driver Left Join Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID IS NULL";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $goodDrivers=$stmt->fetch(PDO::FETCH_ASSOC);

      //find the number of errant drivers in the system 

      $query="SELECT Count(DISTINCT Driver.DriveriD) AS ErrantDrivers From Driver LEFT JOIN Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID is NOT NULL";
      $stmt=$con->prepare($query);
      $stmt->execute();
      $errantDrivers=$stmt->fetch(PDO::FETCH_ASSOC);


      // find number of Male drivers in the system
      

      $query="SELECT Count(Sex) AS Male_Drivers From Driver Where Sex='Male'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $maleDriversTotal=$stmt->fetch(PDO::FETCH_ASSOC);

      $query="SELECT Count(Sex) AS Female_Drivers From Driver Where Sex='Female'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $femaleDriversTotal=$stmt->fetch(PDO::FETCH_ASSOC);

      // find the number of males without an offence record
      $query="SELECT Count(Driver.DriverID) AS GoodMaleDrivers From Driver Left Join Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID IS NULL AND Driver.Sex='Male'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $goodMaleDrivers=$stmt->fetch(PDO::FETCH_ASSOC);
      // find the number of good female drivers
      $query="SELECT Count(Driver.DriverID) AS GoodFemaleDrivers From Driver Left Join Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID IS NULL AND Driver.Sex='Female'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $goodFemaleDrivers=$stmt->fetch(PDO::FETCH_ASSOC);

      // find the number of Errant male drivers

      $query="SELECT Count(DISTINCT Driver.DriveriD) AS ErrantMaleDrivers From Driver LEFT JOIN Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID is NOT NULL AND Driver.Sex='Male'";
      $stmt=$con->prepare($query);
      $stmt->execute();
      $errantMaleDrivers=$stmt->fetch(PDO::FETCH_ASSOC);

      // find the number of Errant female drivers

      $query="SELECT Count(DISTINCT Driver.DriveriD) AS ErrantFemaleDrivers From Driver LEFT JOIN Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID is NOT NULL AND Driver.Sex='Female'";
      $stmt=$con->prepare($query);
      $stmt->execute();
      $errantFemaleDrivers=$stmt->fetch(PDO::FETCH_ASSOC);

      //find the average age of male errant drivers
      $query="SELECT AVG(YEAR(NOW())-YEAR(Driver.DOB)) as AverageErrantMaleDriver From Driver LEFT JOIN Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID is NOT NULL AND Driver.Sex='Male'";
      $stmt=$con->prepare($query);
      $stmt->execute();
      $averageAgeMaleErrant=$stmt->fetch(PDO::FETCH_ASSOC);
      // find the average age of female errant drivers
      $query="SELECT AVG(YEAR(NOW())-YEAR(Driver.DOB)) as AverageErrantFemaleDriver From Driver LEFT JOIN Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID is NOT NULL AND Driver.Sex='Female'";
      $stmt=$con->prepare($query);
      $stmt->execute();
      $averageAgeFemaleErrant=$stmt->fetch(PDO::FETCH_ASSOC);


      ?>

        <div class="row">
        <div class="col-md-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border ">
              <h3 class="box-title">General Driver Statistics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Aggregate Segmentation</strong>
                  </p>

                  <div class="progress-group">
                    <span class="progress-text">Total Number of Drivers:</span>
                    <span class="progress-number"><b><?php echo $totalDrivers['Drivers']; ?></b></span>
                    <hr>

                    
                  </div>

                  <div class="progress-group">
                    <span class="progress-text">Good Drivers (Drivers Without Offence Records):</span>
                    <span class="progress-number"><b><?php echo $goodDrivers['Good_Drivers']; ?></b></span>

                    <hr>
                    

                    
                  </div>
                  <div class="progress-group">
                    <span class="progress-text">Errant Drivers(Drivers With Offence Records):</span>
                    <span class="progress-number"><b><?php echo $errantDrivers['ErrantDrivers'];?></b></span>

                   <hr>
                    

                    
                  </div>


                  <p class="text-center">
                    <strong>Gender Demographic Segmentation (Male)</strong>
                  </p>
                  
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Male Drivers: </span>
                    <span class="progress-number"><b><?php echo $maleDriversTotal['Male_Drivers']; ?></b></span>

                    <hr>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Male Good Drivers: </span>
                    <span class="progress-number"><b><?php echo $goodMaleDrivers['GoodMaleDrivers']; ?></b></span>

                    <hr>
                  </div>
                  <!-- /.progress-group -->


                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Male Errant Drivers: </span>
                    <span class="progress-number"><b><?php echo $errantMaleDrivers['ErrantMaleDrivers']; ?></b></span>

                    <hr>
                  </div>
                  <!-- /.progress-group -->

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Average Age of Errant Male Drivers: </span>
                    <span class="progress-number"><b><?php echo number_format($averageAgeMaleErrant['AverageErrantMaleDriver'],2); ?></b></span>

                    <hr>
                  </div>
                  <!-- /.progress-group -->


                   <p class="text-center">
                    <strong>Gender Demographic Segmentation (Female)</strong>
                  </p>
                  
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Female Drivers: </span>
                    <span class="progress-number"><b><?php echo $femaleDriversTotal['Female_Drivers']; ?></b></span>

                    <hr>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Female Good Drivers: </span>
                    <span class="progress-number"><b><?php echo $goodFemaleDrivers['GoodFemaleDrivers'];?></b></span>

                    <hr>
                  </div>
                  <!-- /.progress-group -->


                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Female Errant Drivers: </span>
                    <span class="progress-number"><b><?php echo $errantFemaleDrivers['ErrantFemaleDrivers'];?></b></span>

                    <hr>
                  </div>
                  <!-- /.progress-group -->

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Average Age of Errant Female Drivers: </span>
                    <span class="progress-number"><b><?php echo number_format($averageAgeFemaleErrant['AverageErrantFemaleDriver'],2);?></b></span>

                    <hr>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">TOTAL REVENUE</span>-->
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
            </div>
          </div>
        </div>


        <?php 

        // queries for Driver-Offence Statistics and Reports

        // Drivers who failed to display Learner L Plates Male
        $query="SELECT COUNT(Distinct Driver.DriverID) AS ErrantMaleLearner FROM Driver Left JOIN Offence On Driver.DriverID=Offence.DriverID Where Offence.OffenseID is not null and Driver.Sex='Male' and Offence.Offence_Type='Learner Failing to exhibit L Plates on the front and rear'";
        $stmt=$con->prepare($query);
        $stmt->execute();

        $errantMaleLearner=$stmt->fetch(PDO::FETCH_ASSOC);


        $query="SELECT COUNT(Distinct Driver.DriverID) AS ErrantFemaleLearner FROM Driver Left JOIN Offence On Driver.DriverID=Offence.DriverID Where Offence.OffenseID is not null and Driver.Sex='Female' and Offence.Offence_Type='Learner Failing to exhibit L Plates on the front and rear'";
        $stmt=$con->prepare($query);
        $stmt->execute();

        $errantFemaleLearner=$stmt->fetch(PDO::FETCH_ASSOC);


        $query="SELECT COUNT(Distinct Driver.DriverID) AS ErrantLearner FROM Driver Left JOIN Offence On Driver.DriverID=Offence.DriverID Where Offence.OffenseID is not null and Offence.Offence_Type='Learner Failing to exhibit L Plates on the front and rear'";
        $stmt=$con->prepare($query);
        $stmt->execute();

        $errantLearner=$stmt->fetch(PDO::FETCH_ASSOC);






        ?>


         <div class="row">
        <div class="col-md-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Driver-Offence Statistics and Report</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Offence Type</th>
                  <th>Male Drivers</th>
                  <th>Female Drivers</th>
                  <th>Total</th>
                  <th style="width: 40px">% of Total</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td><?php echo $errantMaleLearner['ErrantMaleLearner']; ?></td>
                  <td><?php echo $errantFemaleLearner['ErrantFemaleLearner'];?></td>
                  <td><?php echo $errantLearner['ErrantLearner'];?></td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>2.</td>
                  <td>Failing to carry and produce a driving license on demand</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>3.</td>
                  <td>Failure by owner of vehicle to have seat belts in motor vehicle</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>4.</td>
                  <td>Failure to wear a seat belt while the motor vehicle is in motion</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>

                </tr>
                <tr>
                  <td>1.</td>
                  <td>Learner Failing to Exhibit L plates on the front and rear</td>
                  <td>
                    
                  </td>
                  <td></td>
                  <td> </td>
                  <td> </td>
                </tr>
                <tr>
                  
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

      </div>



        <div class="row">
        <div class="col-md-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Driver-Accident Reports</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Task</th>
                  <th>Progress</th>
                  <th style="width: 40px">Label</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Update software</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-red">55%</span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Clean database</td>
                  <td>
                    <div class="progress progress-xs">
                      <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-yellow">70%</span></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Cron job running</td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-primary" style="width: 30%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-light-blue">30%</span></td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Fix and squish bugs</td>
                  <td>
                    <div class="progress progress-xs progress-striped active">
                      <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                    </div>
                  </td>
                  <td><span class="badge bg-green">90%</span></td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php include 'footer.php'?>