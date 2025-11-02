 <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $reward_type   = $_POST['reward_type'];
    $title         = $_POST['title'];
    $type          = $_POST['type'];
    $value         = $_POST['value'];
    $winners       = $_POST['winners'];
    $schedule_date = $_POST['schedule'];
    $status        = 0; // default pending

    // Prepare SQL
    $stmt = $conn->prepare("
        INSERT INTO prize_money_contests 
        (reward_type, title, type, value, winners, schedule_date, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isidisi",
        $reward_type,   // int
        $title,         // string
        $type,          // int
        $value,         // decimal
        $winners,       // int
        $schedule_date, // string
        $status         // int
    );

    if ($stmt->execute()) {
        $message = "🎉 Contest added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM prize_money_contests WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Contest deleted successfully'); window.location='daily_prize.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting contest');</script>";
    }
    $stmt->close();
}
 ?>


 <div class="row">

        <div class="col-12">

          <div class="page-title-box">

            <h4 class="page-title">Daily Prize Money</h4>

          </div>

        </div>

      </div>



<div class="row">



        <div class="col-12">

          <div class="card">

            <div class="card-body">

              <div data-example-id="simple-form-inline">

                <div class="row align-items-center">

                  <div class="col-md-6 mb-2">

                    <button type="button" class="btn btn-danger waves-effect waves-light" id="" data-toggle="modal" data-target="#myModal">Add </button>

                  </div>

                  <div class="col-md-6 mb-2">

                    <div class="d-flex align-items-center">

                      <div class="ml-md-auto">

                        <div class="d-flex align-items-center">

                          <span>Show</span>

                          <select class="form-control mx-1" id="perpage" name="perpage" onchange="perpage_filter()" style="float:left;">



                            <option value="10">10</option>



                            <option value="25">25</option>



                            <option value="50">50</option>



                          </select>

                          <span class="pull-right per-pag">entries</span>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>



              <div class="work-progres">

                <div class="table-responsive">

                   <table class="table table-hover" id="tblname">
    <thead class="thead-light">
      <tr>
        <th>Sno</th>
        <th>Reward Type</th>
        <th>Title</th>
        <th>Type</th>
        <th>Value (Price)</th>
        <th>Winners</th>
        <th>Schedule Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sno = 1;
      $today = date('Y-m-d');
      $result = $conn->query("SELECT * FROM prize_money_contests ORDER BY id DESC");
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $reward_name ='';
              if($row['reward_type'] == 1){
                $reward_name ='Referral Winner';
              }elseif($row['reward_type'] == 2){
                $reward_name ='Daily Prize Money Winner';
              }elseif($row['reward_type'] == 3){
                $reward_name ='Festival Winner';
              }

              $type_name='';
              if($row['type'] == 1){
                $type_name ='Cash';
              }

              
              $status_text = $row['status'] == 1 ? "✅ Completed" : "⏳ Pending";

              echo "<tr>
            <td>{$sno}</td>
            <td>{$reward_name}</td>
            <td>{$row['title']}</td>
            <td>{$type_name}</td>
            <td>₹" . number_format($row['value'], 2) . "</td>
            <td>{$row['winners']}</td>
            <td>{$row['schedule_date']}</td>
            <td>{$status_text}</td>
            <td>
                <a href='?daily_prize_view={$row['id']}' class='btn btn-info btn-sm'>View</a>";

                // Only show Delete button if schedule_date < today
              //  if ($row['schedule_date'] > $today) {
                    echo " <a href='?delete={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this contest?');\">Delete</a>";
               // }

        echo "  </td>
        </tr>";

              $sno++;
          }
      } else {
          echo "<tr><td colspan='9' class='text-center text-muted'>No records found</td></tr>";
      }
      ?>
    </tbody>
  </table>
                </div>

                <div class="clearfix"> </div>

                <div class="row align-items-center">

                  <div class="col-md-6">

                    <div class="pull-right" style="float:left;">

                      Total Row : <a id="totalrowvalue" class="totalrowvalue"></a>

                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="pull-right page_div ml-auto" style="float:right;"> </div>

                  </div>

                </div>

              </div>



              <div class="col_1">



                <div class="clearfix"> </div>



              </div>

            </div>

          </div>

        </div>

      </div>



<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
         <form method="POST" action="">

          <div class="form-row">
            
            <div class="form-group col-md-6">
              <label for="reward_type">Type of Reward</label>
              <select class="form-control" name="reward_type" required>
                <option value="">Select</option>
                <option value="1">Referral Winner</option>
                <option value="2">Daily Prize Money Winner</option>
                <option value="3">Festival Winner</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="title">Title</label>
              <input type="text" class="form-control" required name="title" placeholder="Enter title">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="type">Type</label>
              <select class="form-control" required name="type">
                <option value="">Select</option>
                <option value="1">Cash</option>
                <option value="2">New User Bonus</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="value">Each Prize Money Value</label>
              <input type="text" class="form-control" required name="value" placeholder="₹0.00">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="winners">No. of Winners</label>
              <input type="number" class="form-control" required name="winners" placeholder="Enter number">
            </div>
            <div class="form-group col-md-6">
              <label for="schedule">Schedule Date</label>
              <input type="date" class="form-control" required name="schedule">
            </div>
          </div>

          <div class="text-center mt-3">
            <button type="submit" class="btn btn-dark">Save</button>
            <button type="reset" class="btn btn-outline-secondary ml-2">Reset</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>