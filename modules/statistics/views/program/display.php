<?php
$tmpl->addScript('program.activity', 'modules/statistics/assets/js');
$tmpl->addScript('program', 'modules/statistics/assets/js');
$tmpl->addScript('thickbox');
$tmpl->addScript('highcharts', 'libraries/jquery/highcharts');
$tmpl->addScript('exporting', 'libraries/jquery/highcharts');
$tmpl->addStylesheet('jquery-ui', 'libraries/jquery/jquery.ui');
$tmpl->addScript('jquery-ui', 'libraries/jquery/jquery.ui');
$tmpl->addStylesheet('thickbox'); 
?>
<div class="event-title">
    <?php echo FSText::_('Hệ thống Dữ liệu phục vụ Theo dõi, Đánh giá và Chia sẻ kinh nghiệm Công tác XTTM');?> 
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <div class="ci-heading"><?php echo FSText::_('Xem báo cáo chi tiết');?></div>
    <table class="table-form">
        <tr>
            <td class="label w110px"><?php echo FSText::_('Chương trình');?>:</td>
            <td>
                <select cvalue="<?php echo $program ?>" id="program" name="program" class="form w215px" onchange="window.location=this.value;">
                    <?php foreach($arrProgram as $key=>$val){?>
                        <option <?php if($program == $key) echo 'selected="selected"'; ?> value="<?php echo FSRoute::_('index.php?module=statistics&view=program&task=display&program='.$key) ?>"><?php echo $val ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    </table>
    <div style="width: 1101px;">
        <div class="box-left" style="width: 485px; float: left;">
            <div class="form-views">
                <table class="table-form" style="table-layout: fixed;">
                    <tr>
                        <td style="width: 352px;">
                            <select id="ccity" name="city" class="form w180px">
                                <?php foreach($cities as $key=>$val){?>
                                    <option value="<?php echo $key ?>"><?php echo $val ?></option>
                                <?php } ?>
                            </select>
                            <select id="cquarter" name="quarter" class="form w150px">
                                <?php foreach($arrQuarterCurrent as $key=>$val){?>
                                    <option value="<?php echo $val['text'] ?>"><?php echo $val['text'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input onclick="showReportCity();" type="submit" value="<?php echo FSText::_('Xem báo cáo') ?>" /></td>
                    </tr>
                    <tr>
                        <td style="width: 352px;">
                            <select id="rregions" name="regions" class="form w180px">
                                <?php foreach($cArrRegions as $key=>$val){?>
                                    <option value="<?php echo $key ?>"><?php echo $val ?></option>
                                <?php } ?>
                            </select>
                            <select id="rquarter" name="quarter" class="form w150px">
                                <?php foreach($arrQuarterCurrent as $key=>$val){?>
                                    <option value="<?php echo $val['text'] ?>"><?php echo $val['text'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input onclick="showReportRegion();"  type="submit" value="<?php echo FSText::_('Xem báo cáo') ?>" /></td>
                    </tr>
                    <tr>
                        <td style="width: 352px;">
                            <select id="iindustries" name="industries" class="form w180px">
                                <?php foreach($arrIndustries as $key=>$val){?>
                                    <option value="<?php echo $key ?>"><?php echo $val ?></option>
                                <?php } ?>
                            </select>
                            <select id="iquarter" name="quarter" class="form w150px">
                                <?php foreach($arrQuarterCurrent as $key=>$val){?>
                                    <option value="<?php echo $val['text'] ?>"><?php echo $val['text'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input onclick="showReportIndustry();"  type="submit" value="<?php echo FSText::_('Xem báo cáo') ?>" /></td>
                    </tr>
                    <tr>
                        <td style="width: 352px;">
                            <input type="text" class="form w338px blue" readonly="readonly" value="<?php echo FSText::_('Kết quả và bài học kinh nghiệm') ?>" />
                        </td>
                        <td><input onclick="showLessonsLearned();" type="submit" value="<?php echo FSText::_('Xem báo cáo') ?>"  /></td>
                    </tr>
                    <tr>
                        <td style="width: 352px;">
                            <input type="text" class="form w338px blue" readonly="readonly" value="<?php echo FSText::_('Thống kê một số chỉ số cơ bản') ?>" />
                        </td>
                        <td><input onclick="showBasicIndices();" type="submit" value="<?php echo FSText::_('Xem báo cáo') ?>" /></td>
                    </tr>
                </table><br />
                <table id="program-activity" class="data-table" style="table-layout: fixed; width: 485px;">
                    <tr>
                        <td class="bg-blue bold white center" rowspan="2" style="width: 165px;">
                            <?php echo FSText::_('Các hoạt động chính trong quý') ?>
                            <select id="mquarter" name="mquarter" class="form" style="float: right; margin-right: 12px;" onchange="showMainActivities();">
                                <?php
                                $tmpQuarterCurrent = $arrQuarterCurrent;
                                arsort($tmpQuarterCurrent);
                                foreach($tmpQuarterCurrent as $key=>$val){?>
                                    <option value="<?php echo $val['text'] ?>"><?php echo $val['text'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td class="bg-gray center" colspan="3"><?php echo FSText::_('Do chương trình triển khai') ?></td>
                        <td style="width: 80px;" class="bg-gray center" rowspan="2"><?php echo FSText::_('Do các tỉnh tự thực hiện') ?></td>
                    </tr>
                    <tr>
                        <td style="width: 80px;" class="bg-gray center"><?php echo FSText::_('Đã thực hiện từ đầu dự án') ?></td>
                        <td style="width: 80px;" class="bg-gray center"><?php echo FSText::_('Kế hoạch cho Quý') ?></td>
                        <td class="bg-gray center"><?php echo FSText::_('Đã thực hiện trong Quý') ?></td>
                    </tr>
                    <?php foreach($arrActivityType as $key=>$val){?>
                        <tr>
                            <td class="bg-gray"><?php echo $val ?></td>
                            <td class="<?php echo $key ?>-in center"></td>
                            <td class="<?php echo $key ?>-quarter center"></td>
                            <td class="<?php echo $key ?>-implemented center"></td>
                            <td class="<?php echo $key ?>-out center"></td>
                        </tr>
                    <?php } ?>
                </table>
            </div><!--end: .form-views-->
        </div><!--end: .box-left-->
        <div class="box-right" style="width: 595px; float: left; margin-left: 20px;">
            <table id="synthesis_report" class="data-table" style="table-layout: fixed; width: 595px;">
                <tr>
                    <td class="bg-yellow bold white" colspan="2" style="vertical-align: middle;">
                        <?php echo FSText::_('Một số kết quả cập nhật tới cuối quý trước') ?>
                        <select id="quarter" name="quarter" class="form" style="float: right; margin-right: 12px;" onchange="showSynthesisReport();">
                            <?php foreach($arrQuarterCurrent as $key=>$val){?>
                                <option value="<?php echo $val['text'] ?>"><?php echo $val['text'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Tỉnh có gia tăng cán bộ có kiến thức về ngành hàng xuất khẩu chủ đạo của địa phương') ?></td>
                    <td>
                        <div class="officials_knowledge">0</div>
                        <div><a data-key="officials_knowledge" onclick="showCityReportProgram(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Bảng liệt kê các tỉnh') ?></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Tỉnh có gia tăng số cán bộ của tỉnh có kỹ năng XTTM') ?></td>
                    <td>
                        <div class="officials_xttm">0</div>
                        <div><a data-key="officials_xttm" onclick="showCityReportProgram(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Bảng liệt kê các tỉnh') ?></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Tỉnh có gia tăng số cán bộ của tỉnh có kỹ năng quản lý khách hàng') ?></td>
                    <td>
                        <div class="officials_customer">0</div>
                        <div><a data-key="officials_customer" onclick="showCityReportProgram(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Bảng liệt kê các tỉnh') ?></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Tỉnh xây dựng được Chiến lược XTTM phù hợp với tình hình địa phương, có tham vấn doanh nghiệp và các bên liên quan') ?></td>
                    <td>
                        <div class="provincial_building_strategy">0</div>
                        <div><a data-key="provincial_building_strategy" onclick="showCityReportProgram(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Danh sách TPO') ?></div>
                        <div><a data-key="provincial_building_strategy" onclick="showCityOutcomeProgram(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="javascript:void(0);"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Tỉnh sử dụng mô hình Benchmarking để tự đánh giá') ?></td>
                    <td>
                        <div class="business_benchmarking">0</div>
                        <div><a data-key="business_benchmarking" onclick="showCityReportProgram(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Danh sách TPO') ?></div>
                        <div><a data-key="business_benchmarking" onclick="showCityOutcomeProgram(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="javascript:void(0);"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Tăng trưởng doanh thu xuất khẩu của các DNNVV tham gia Chương trình') ?></td>
                    <td>
                        <div class="export_sales">0</div>
                        <div><a data-key="export_sales" onclick="showReportBusiness(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 10 doanh nghiệp tốt nhất') ?></div>
                        <div><a data-key="export_sales" onclick="showReportBusinessCities(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 3 tỉnh tốt nhất') ?></div>
                        <div><a data-key="export_sales" onclick="showReportBusinessIndustries(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 3 ngành tốt nhất') ?></div>
                        <div><a class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="javascript:void(0);"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Số thị trường mới mở') ?></td>
                    <td>
                        <div class="new_markets">0</div>
                        <div><a data-key="new_markets" onclick="showReportBusiness(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 10 doanh nghiệp tốt nhất') ?></div>
                        <div><a data-key="new_markets" onclick="showReportBusinessCities(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 3 tỉnh tốt nhất') ?></div>
                        <div><a data-key="new_markets" onclick="showReportBusinessIndustries(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 3 ngành tốt nhất') ?></div>
                        <div><a class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="javascript:void(0);"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 345px;"><?php echo FSText::_('Số khách hàng mới') ?></td>
                    <td>
                        <div class="new_clients">0</div>
                        <div><a data-key="new_clients" onclick="showReportBusiness(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 10 doanh nghiệp tốt nhất') ?></div>
                        <div><a data-key="new_clients" onclick="showReportBusinessCities(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 3 tỉnh tốt nhất') ?></div>
                        <div><a data-key="new_clients" onclick="showReportBusinessIndustries(this);" class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('Top 3 ngành tốt nhất') ?></div>
                        <div><a class="a-report" href="javascript:void(0);"><?php echo FSText::_('Xem') ?></a></a> <a class="a-learned" href="javascript:void(0);"><?php echo FSText::_('bài học kinh nghiệm') ?></a></div>
                    </td>
                </tr>
            </table>
            <script type="text/javascript">
            $(document).ready(function(){
                showSynthesisReport();
            });
            </script>
        </div><!-- .box-right-->
    </div>
    <div class="clearfix"></div>
    <a style="font-weight: bold; text-decoration: none; font-size: 12; color: #ff0000;" class="excel thickbox" href="<?php echo FSRoute::_('index.php?module=statistics&view=program&raw=1&task=open_list_program_box&height=250&width=400&modal=true') ?>"><img src="/images/excel.png" />&nbsp;Danh mục hoạt động/ List of Activities</a>&nbsp;&nbsp;&nbsp;
    <a style="font-weight: bold; text-decoration: none; font-size: 12; color: #ff0000;" class="excel thickbox" href="<?php echo FSRoute::_('index.php?module=statistics&view=program&raw=1&task=open_logframe&height=250&width=400&modal=true') // FSRoute::_('index.php?module=statistics&view=program&raw=1&task=logframe') ?>"><img src="/images/excel.png" />&nbsp;Logframe</a>
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="statistics-program-display" />