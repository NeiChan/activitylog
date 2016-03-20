<div class="container">
    <h2>See all your activities here</h2>

    <div class="box">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit an activity</strong></h3>
                    </div>
                    <div class="panel-body">
                        <form id="form-reset" action="<?php echo URL; ?>activities/update/<?php echo $activity["main"]->id; ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="sr-only" for="date">Calendar</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                            <input name="date" type="date" class="form-control" id="date" value="<?php echo $activity["main"]->l_date; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="sr-only" for="time">Time</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="glyphicon glyphicon-time"></span></div>
                                            <input class="form-control" type="text" name="time" value="<?php echo $activity["main"]->l_time; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12"><label>Title</label><input class="form-control" type="text" name="title" value="<?php echo $activity["main"]->titel; ?>" required /></div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12"><label>Description</label><input class="form-control" type="text" name="description" value="<?php echo $activity["main"]->description; ?>" required /></div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Categories</label>
                                    <select name="categories" class="form-control selector-categories">
                                        <?php foreach ($categories as $category) { ?>
                                            <option value="<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8') ?>" <?php if($activity["main"]->category_id == $category->id){ echo 'selected="selected"'; } ?>><?php echo htmlspecialchars($category->titel, ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-sm-3 form-control-label">Data types</label>
                                <div class="col-md-9">
                                    <select name="datatypes[]" class="selector-dropdown-datatypes" multiple="multiple">
                                        <?php
                                        foreach($datatypes as $index => $datatype)
                                        {
                                            if($datatype->id == $activity["datatypes"][$index]->id)
                                            {
                                                ?>
                                                <option value="<?php echo htmlspecialchars($datatype->id, ENT_QUOTES, 'UTF-8') ?>" selected="selected"><?php echo htmlspecialchars($datatype->titel, ENT_QUOTES, 'UTF-8') ?></option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="<?php echo htmlspecialchars($datatype->id, ENT_QUOTES, 'UTF-8') ?>"><?php echo htmlspecialchars($datatype->titel, ENT_QUOTES, 'UTF-8') ?></option>
                                                <?php
                                            }
                                        } ?>
                                    </select>
                                    <button id="deselectAll-datatypes" class="btn btn-default">Deselect all options</button>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <label class="col-sm-3 form-control-label">Companies</label>
                                <div class="col-md-9">
                                    <select name="companies[]" class="selector-dropdown-companies" multiple="multiple">
                                        <?php
                                        foreach($companies as $index => $company)
                                        {
                                            if($company->id == $activity["companies"][$index]->id)
                                            {

                                            ?>
                                                <option value="<?php echo htmlspecialchars($company->id, ENT_QUOTES, 'UTF-8') ?>" selected="selected"><?php echo htmlspecialchars($company->titel, ENT_QUOTES, 'UTF-8') ?></option>
                                            <?php
                                            }else{
                                        ?>
                                            <option value="<?php echo htmlspecialchars($company->id, ENT_QUOTES, 'UTF-8') ?>"><?php echo htmlspecialchars($company->titel, ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php
                                            }
                                        } ?>
                                    </select>
                                    <button id="deselectAll-companies" class="btn btn-default">Deselect all options</button>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Location</label>
                                    <br/>
                                    <input id="pac-input" class="controls" type="text" placeholder="Enter a location">
                                    <input id="lat" type="hidden" name="lat" value="<?php echo $activity["main"]->l_lat; ?>">
                                    <input id="long" type="hidden" name="long" value="<?php echo $activity["main"]->l_long; ?>">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <br/>
                            <input type="submit" name="submit_update_activity" value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="timeline">
                    <dl>
                    <?php foreach ($activities as $activity) { ?>
                        <?php if(isset($activity->id)): ?>
                        <?php
                            // ********* HEADLINE ********* //
                            $date = date_format(date_create($activity->l_date), 'jS M Y');
                            if($date != $currentHeadlineDate):
                                $currentHeadlineDate = $date;
                                $counter ++;
                        ?>
                        <dt><?php echo $currentHeadlineDate; ?></dt>
                            <?php endif;
                            // ********* END HEADLINE ********* //
                        ?>
                        <dd class="<?php if($counter % 2 == 0) { echo 'pos-left'; }else{ echo 'pos-right'; } ?> clearfix">
                            <div class="circ"></div>
                            <div class="time"><?php echo htmlspecialchars($activity->l_time, ENT_QUOTES, 'UTF-8');?></div>
                            <div class="events">
<!--                                <div class="pull-left">-->
<!--                                    <img class="events-object img-rounded" src="http://loremflickr.com/64/64/cat">-->
<!--                                </div>-->
                                <div class="events-body">
                                    <h4 class="events-heading"><?php echo htmlspecialchars($activity->titel, ENT_QUOTES, 'UTF-8');?></h4>
                                    <p><?php echo htmlspecialchars($activity->description, ENT_QUOTES, 'UTF-8');?></p>

                                    <?php
                                    $current_cat = $this->model->getCategory($activity->category_id);
                                    echo '<span class="label label-default">'.$current_cat->titel.'</span>';
                                    ?>
                                    <br/><br/>

                                    <span class="label label-primary">Data types</span>
                                    <ul>
                                        <?php
                                        $datatypes = $this->model->getActivityDataTypes($activity->id, $_SESSION["User"]);
                                        foreach($datatypes as $data_names)
                                        {
                                             echo '<li>'.$data_names->titel.'</li>';
                                        }
                                        ?>
                                    </ul>

                                    <span class="label label-danger">Companies</span>
                                    <ul>
                                        <?php
                                        $companies = $this->model->getActivityCompanies($activity->id, $_SESSION["User"]);
                                        foreach($companies as $company_names)
                                        {
                                            echo '<li>'.$company_names->titel.'</li>';
                                        }
                                        ?>
                                    </ul>

                                    <img border="0" src="https://maps.googleapis.com/maps/api/staticmap?zoom=13&size=250x150&maptype=roadmap
                                    &markers=color:blue%7Clabel:Location%7C<?php echo $activity->l_lat?>,<?php echo $activity->l_long; ?>&key=AIzaSyBdImcQ9RZXL2a2tILaW95pKYusoMWK6-M"/>

                                    <br/>
                                    <br/>

                                    <div class="pull-right">
                                        <a class="btn btn-warning" href="<?php echo URL . 'activities/edit/' . htmlspecialchars($activity->id, ENT_QUOTES, 'UTF-8'); ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a class="btn btn-danger"href="<?php echo URL . 'activities/delete/' . htmlspecialchars($activity->id, ENT_QUOTES, 'UTF-8'); ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                    </div>
                                </div>
                            </div>
                        </dd>
                        <?php endif; ?>
                    <?php } ?>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
