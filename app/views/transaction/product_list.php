<table class="table table-sm table-striped" id="table_product_list" style="width:100%">
  <thead>
    <tr>
      <th style='display: none'></th>
      <th style="width: 30px" class="text-center">No.</th>
      <th>Product Name</th>
      <th>Description</th>
      <th>Price</th>
      <th>On Hand</th>
      <th style="width:10px">Control</th>
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
            <td style='display: none'><?php echo $product_detail->id ?></td>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td><?php echo $product_detail->name ?></td>
            <td><?php echo $product_detail->description; ?></td>
            <td><?php echo number_format((float)$product_detail->price, 2, '.', ''); ?></td>
            <td><?php echo $product_detail->quantity; ?></td>
            <td>
              <button class="btn btn-sm btn-success" id="btn_select_product_control" value="<?php echo $product_detail->id; ?>"><i class="fas fa-mouse-pointer"></i>&nbsp;Select</button>
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
                          "pageLength": 5
                        });
</script>