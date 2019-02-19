<?php foreach($result['hotels'] as $row ) { ?>
    <div class="col-md-6 col-sm-6 animate-box" style="min-height: 500px;">
        <div class="hotel-entry">
            <a href="inner_hotel/<?php echo  $row['id']; ?>" class="hotel-img" style="background-image: url(<?php echo base_url() ?>images/<?php echo  $row['image']; ?>">
                <p class="price"><span>$<?php echo  $row['cost']; ?></span><small> /night</small></p>
            </a>
            <div class="desc">
                <h3><a href="inner_hotel/<?php echo  $row['id']; ?>"><?php echo  $row['name']; ?></a></h3>
                <span class="place"><?php echo  $row['address']; ?></span>
            </div>
            <div class="desc">
                <h5>Available Rooms</h5>
                <?php 
                    $searchFor = $row['id'];
                    $filteredArray = array_filter($result['rooms'], function($element) use($searchFor) {
                                        return isset($element['hotel_id']) && $element['hotel_id'] == $searchFor;
                                    });
                    foreach($filteredArray as $row1) {
                        echo "<li>". $row1['type'] ." | $". $row1['cost']."</li>";
                    }
                ?>
            </div>
        </div>
    </div>
<?php } ?>