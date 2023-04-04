<?php
// Get the order ID from the URL parameter or the POST data
$id = isset($_GET['id']) ? $_GET['id'] : $this->input->get('id');
$data = $this->session->userdata('order_data');
$id = $this->session->userdata('order_id');
if (isset($data)) {
    $order = $data['order'];
    $order_items = $data['order_items'];
    $suppliers = $data['suppliers'];
    $products = $data['products'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Order</title>
    <link rel="stylesheet" href="<?php echo base_url('/css/homepage_style.css') ?>">
</head>

<body>
    <div class="container-flex">
        <div class="content">
            <h2 class="title">Edit Order</h2>
            <hr>

            <form method="post" id="order-form">
                <div class="form-group">
                    <label for="observations">Observations</label>
                    <textarea id="observations" name="observations"
                        class="form-control"><?php echo $order['observations'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" <?php echo ($order['status'] == 'active') ? 'selected' : '' ?>>Active
                        </option>
                        <option value="finished" <?php echo ($order['status'] == 'finished') ? 'selected' : '' ?>>Finished
                        </option>
                    </select>
                </div>
                <button id="save-status-btn" type="submit" class="btn btn-primary">Save</button>
            </form>

            <form action="<?php echo base_url('update_order?id=' . $id) ?>" method="post">
                <input type="hidden" name="order_id" value="<?php echo $id ?>">

                <div class="form-group">
                    <h3>Order Items</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Supplier</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $key => $item): ?>
                                <tr>
                                    <td>
                                        <?php echo $item['product'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['supplier_id'] ?>
                                    </td>
                                    <td><input type="number" name="quantity[]" value="<?php echo $item['quantity'] ?>"
                                            class="form-control"></td>
                                    <td>
                                        <?php echo $item['price'] ?>
                                    </td>
                                    <td>
                                        <?php echo $item['quantity'] * $item['price'] ?>
                                    </td>
                                    <td><a href="<?php echo site_url('/remove_item_from_update/' . $key) ?>">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
            </form>
            <form action="<?php echo base_url('add_item_to_session?id=' . $id) ?>" method="post">
                <div class="form-group">
                    <label for="supplier_id">Supplier:</label>
                    <select id="supplier_id" name="supplier_id">
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?php echo $supplier['collaborator_id'] ?>"><?php echo $supplier['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="product_id">Product:</label>
                    <select id="product_id" name="product_id">
                        <?php foreach ($products as $product): ?>
                            <option value="<?php echo $product['product_id'] ?>"><?php echo $product['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                    <button type="submit" name="add_item" value='1'>Add Item</button>
                </div>
            </form>
        </div>

        <div class="form-group">
            <a href="<?php echo site_url('update_order_db'); ?>" class="btn btn-primary btn-sm add-item">Update
                Order</a>
        </div>
        <li><a href="<?php echo site_url('/orders') ?>">Orders</a></li>
    </div>
    </div>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#save-status-btn').click(function (e) {
                e.preventDefault();
                var formData = $('#order-form').serialize();
                $.ajax({
                    url: '/set_status_session',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>