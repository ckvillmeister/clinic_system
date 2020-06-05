<style type="text/css">
  .controls {
    width: 70px;
  }
</style>
<table class="table table-sm table-striped" id="table_product_list" style="width:100%">
  <thead>
    <tr>
      <th style="width: 30px" class="text-center">No.</th>
      <th>Product Name</th>
      <th>Description</th>
      <th>Unit of Measurement</th>
      <th>Price</th>
      <th>Quantity on Hand</th>
      <th>Re-order Level</th>
      <th>Added By</th>
      <th style="width:180px">Control</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $products = $data['products'];
      $status = $data['status'];
      $ctr = 0;
      foreach ($products as $key => $product) {
          $product_detail = (object) $product;
    ?>
          <tr>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td><?php echo $product_detail->name ?></td>
            <td><?php echo $product_detail->description; ?></td>
            <td><?php echo $product_detail->uom; ?></td>
            <td><?php echo number_format((float)$product_detail->price, 2, '.', ''); ?></td>
            <td><?php echo $product_detail->quantity; ?></td>
            <td><?php echo $product_detail->reorder; ?></td>
            <td><span class="badge bg-secondary"><?php echo $product_detail->createdby; ?></span></td>
            <td>
              <?php
                if ($status == 1){
              ?>
              <button class="btn btn-sm btn-warning controls" id="btn_edit_control" value="<?php echo $product_detail->id; ?>"><i class="fas fa-edit"></i>&nbsp;Edit</button>
              <button class="btn btn-sm btn-danger controls" id="btn_delete_control" value="<?php echo $product_detail->id; ?>"><i class="fas fa-trash"></i>&nbsp;Delete</button>
              <?php }
                elseif ($status == 0){
              ?>
              <button class="btn btn-sm btn-success controls" id="btn_reactivate_control" value="<?php echo $product_detail->id; ?>" style="width:100px"><i class="fas fa-check"></i>&nbsp;Re-Activate</button>
              <?php
                }
              ?>
            </td>
          </tr>
    <?php
      }
    ?>
  </tbody>
</table>
<script type="text/javascript">
  var dt_product_list = $('#table_product_list').DataTable({
                  "ordering": false,
                  "pageLength": 10,
                  "deferRender": true,
                  "responsive": true,
                  "scrollY": true,
              });
</script>