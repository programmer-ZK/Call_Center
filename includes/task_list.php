
<?php
	include_once("classes/task_list.php");
	$task_list = new task_list();

	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	
?>
<div class="box" id="to-do">
              <ul class="tab-menu">
                  <li><a href="#to-dos">To Do</a></li>
                  <li><a href="#completed">Completed</a></li>
              </ul>
              <div class="box-container" id="to-dos">
                 <div id="to-do-list">
                    <ul>
					<?php               $rs = $task_list->get_user_tasks(1);
                                        while(!$rs->EOF){ ?>
                        <li class="even"><input name="check" type="checkbox" value="" />
                        <a href="#"><?php echo $rs->fields["title"]; ?></a><br />
                        <small><strong>Deadline:</strong><?php echo $rs->fields["deadline"]; ?></small>
                        </li>
                   
						 <?php
                                        $rs->MoveNext();
                                        }
                                ?>
                    </ul>
                    <div class="inner-nav">
                        <div class="align-left"><a href="task_list.php?from=todo"><span>view all</span></a></div>
                     <!--   <div class="align-right"><a href="#"><span>to-do config</span></a></div>-->
                        <span class="clearFix">&nbsp;</span>
                    </div>
                  </div><!-- end of div#to-do-list -->
              </div><!-- end of div.box-container -->

              <div class="box-container" id="completed">
			   <div id="to-do-list">
                    <ul>
					<?php               $rs = $task_list->get_user_tasks(0);
                                        while(!$rs->EOF){ ?>
                        <li class="even"><input name="check" type="checkbox" value="" />
                        <a href="#"><?php echo $rs->fields["title"]; ?></a><br />
                        <small><strong>Deadline:</strong><?php echo $rs->fields["deadline"]; ?></small>
                        </li>
                       
						 <?php
                                        $rs->MoveNext();
                                        }
                                ?>
                    </ul>
                    <div class="inner-nav">
                        <div class="align-left"><a href="task_list.php?from=complete"><span>view all</span></a></div>
                        <!--<div class="align-right"><a href="#"><span>to-do config</span></a></div>-->
                        <span class="clearFix">&nbsp;</span>
                    </div>
                  </div><!-- end of div#to-do-list -->
			  </div>
          </div><!-- end of div.box -->
