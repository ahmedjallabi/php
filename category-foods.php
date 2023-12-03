<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <?php
        // Récupérer l'ID de l'aliment depuis l'URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Requête SQL pour récupérer les détails de l'aliment
            $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

            // Exécuter la requête SQL
            $res2 = mysqli_query($conn, $sql2);

            // Vérifier si l'aliment existe
            $count = mysqli_num_rows($res2);

            if ($count == 1) {
                // Récupérer les données de l'aliment
                $row2 = mysqli_fetch_assoc($res2);
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_name'];
                $current_category = $row2['category_id'];
                $featured = $row2['featured'];
                $active = $row2['active'];
            } else {
                $_SESSION['no-food-found'] = "Food not found!";
                header('location:' . SITEURL . 'admin/manage-food.php');
            }
        } else {
            header('location:' . SITEURL . 'admin/manage-food.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table width="30%">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php if ($current_image != "") { ?>
                            <img src="<?php echo SITEURL; ?>images/foods/<?php echo $current_image; ?>" width="150px">
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                            // Requête SQL pour obtenir toutes les catégories actives
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            // Vérifier s'il y a des catégories
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                                }
                            } else {
                                ?>
                                <option value="0">No Category Found</option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Vérifier si le formulaire a été soumis
        if (isset($_POST['submit'])) {
            // Récupérer
