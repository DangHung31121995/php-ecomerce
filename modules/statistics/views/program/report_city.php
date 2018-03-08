<div class="tbpopup-title">
    Tỉnh/Thành phố <?php echo $city->name ?> - Quý <?php echo $quarter ?> - <?php echo $arrProgram[$program] ?>
    <a class="close-popup" href="javascript:void(0);" onclick="self.parent.tb_remove();"><img src="/images/demo/close.png" /></a>
</div><!--end: .tbpopup-title-->
<div class="tbpopup-content">
    <style>
        #tbl-report-city td{
            padding-top: 20px;
            padding-bottom: 19px;
        }
    </style>
    <table id="tbl-report-city" class="data-table" style="table-layout: fixed; width: 505px; border: 1px solid #a1aebc !important; float: left;">
        <tr>
            <td class="bg-gray" style="width: 255px;"><?php echo FSText::_('Tăng trưởng doanh thu xuất khẩu của các DNNVV tham gia Chương trình') ?></td>
            <td class="center" style="width: 55px;"><?php echo $aProgram['export_sales'] ?></td>
            <td>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('5 doanh nghiệp tốt nhất') ?></div>
                <?php /* <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('3 ngành tốt nhất') ?></div> */?>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="#"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                <div>&nbsp;</div>
            </td>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 255px;"><?php echo FSText::_('Tăng trưởng doanh số bán hàng của các DNNVV tham gia Chương trình') ?></td>
            <td class="center" style="width: 55px;"><?php echo $aProgram['sales'] ?></td>
            <td>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('5 doanh nghiệp tốt nhất') ?></div>
                <?php /* <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('3 ngành tốt nhất') ?></div> */?>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="#"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                <div>&nbsp;</div>
            </td>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 255px;"><?php echo FSText::_('Số thị trường mới mở của các DN tham gia Chương trình trong kỳ báo cáo') ?></td>
            <td class="center" style="width: 55px;"><?php echo $aProgram['new_markets'] ?></td>
            <td>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('5 doanh nghiệp tốt nhất') ?></div>
                <?php /* <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('3 ngành tốt nhất') ?></div> */?>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="#"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                <div>&nbsp;</div>
            </td>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 255px;"><?php echo FSText::_('Số khách hàng mới của các DN tham gia Chương trình trong kỳ báo cáo') ?></td>
            <td class="center" style="width: 55px;"><?php echo $aProgram['new_clients'] ?></td>
            <td>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('5 doanh nghiệp tốt nhất') ?></div>
                <?php /* <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <?php echo FSText::_('3 ngành tốt nhất') ?></div> */?>
                <div><a class="a-report" href="#"><?php echo FSText::_('Xem') ?></a> <a class="a-learned" href="#"><?php echo FSText::_('Bài học kinh nghiệm') ?></a></div>
                <div>&nbsp;</div>
            </td>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 255px;"><?php echo FSText::_('Số DN có sản phẩm xuất khẩu mới') ?></td>
            <td colspan="2" class="center" style="width: 55px;"><?php echo $aProgram['new_products'] ?></td>
        </tr>
        <tr>
            <td class="bg-gray" style="width: 255px;"><?php echo FSText::_('Thay đổi số cán bộ của tỉnh có kiến thức về ngành hàng') ?></td>
            <td colspan="2" class="center" style="width: 55px;"><?php echo $aProgram['officials_knowledge']; ?></td>
        </tr>
    </table>
    <div style="display: inline-block; float: left; margin-left: 10px;">
        <div id="statistics_cities" class="sys-chart" style="width: 655; height: 513px; border: 1px solid #dddddd;"></div>
        <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
        		type : 'POST',
                dataType: 'json',
        		url : '/index.php?module=statistics&view=program&raw=1&task=get_statistics_by_city',
                data: {'id': <?php echo $city->id ?>, 'quarter': '<?php echo $quarter ?>'},
                success : function($json){
                    $('#statistics_cities').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '<?php echo FSText::_('Biểu đồ số doanh nghiệp tham gia hoạt động trong và ngoài chương trình tỉnh')?> <?php echo $city->name ?>'
                        },
                        subtitle: {
                            text: 'Quý <?php echo $quarter ?>'
                        },
                        xAxis: {
                            categories: $json.categories,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '<?php echo FSText::_('Số doanh nghiệp tham gia')?>'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: $json.series
                    });
                }
            });
        });
        </script>
    </div>
    <div class="clearfix"></div>
    <br /><br />
    <table id="tbl-report-activity" class="data-table" style="table-layout: fixed; border: 1px solid #a1aebc !important;">
        <tr>    
            <td class="bg-yellow bold white" style="width: 280px;">
                <?php echo FSText::_('Thông tin về hoạt động') ?>
            </td>
            <td class="center bg-gray"><?php echo FSText::_('Tổng số') ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center bg-gray"><?php echo $val ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Số hoạt động đã tham gia cùng Chương trình') ?>
            </td>
            <td class="center"><?php echo $aProgram['activity']['total'] ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo $aProgram['activity'][$key] ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Số cán bộ tham gia theo từng loại hoạt động với Chương trình') ?>
            </td>
            <td class="center"><?php echo $aProgram['staffd']['total'] ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo $aProgram['staffd'][$key] ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Số lượt cán bộ tham gia theo từng loại hoạt động với Chương trình') ?>
            </td>
            <td class="center"><?php echo $aProgram['staff']['total'] ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo $aProgram['staff'][$key] ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Số doanh nghiệp của tỉnh tham gia các hoạt động với Chương trình') ?>
            </td>
            <td class="center"><?php echo $aProgram['persond']['total'] ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo $aProgram['persond'][$key] ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Số lượt doanh nghiệp tham gia hoạt động với Chương trình') ?>
            </td>
            <td class="center"><?php echo $aProgram['person']['total'] ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo $aProgram['person'][$key] ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Số hoạt động do tỉnh tự triển khai ngoài Chương trình') ?>
            </td>
            <td class="center"><?php echo $aProgram['oActivity']['total'] ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo $aProgram['oActivity'][$key] ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Số doanh nghiệp của tỉnh tham gia các hoạt động do tỉnh tự triển khai') ?>
            </td>
            <td class="center"><?php echo $aProgram['oPerson']['total'] ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo $aProgram['oPerson'][$key] ?></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Doanh số gia tăng từ các hoạt động') ?>
            </td>
            <td class="center"></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"></td>
            <?php } ?>
        </tr>
        <tr>    
            <td class="bg-gray" style="width: 280px;">
                <?php echo FSText::_('Kinh phí đối ứng') ?>
            </td>
            <td class="center"><?php echo number_format($aProgram['budget_reciprocal']['total'], 0, ',', '.') ?></td>
            <?php foreach($arrActivityType as $key=>$val){ ?>
                <td class="center"><?php echo number_format($aProgram['budget_reciprocal'][$key], 0, ',', '.') ?></td>
            <?php } ?>
        </tr>
    </table>
    <a onclick="alert('Chức năng này đang hoàn thiện');" style="font-weight: bold; text-decoration: none; font-size: 12; color: #ff0000;" class="functions_built word" href="javascript:void(0);"><img src="/images/word.png" />&nbsp;<?php echo FSText::_('Xuất báo cáo ra file Word')?></a>&nbsp;&nbsp;&nbsp;<a onclick="alert('Chức năng này đang hoàn thiện');" style="font-weight: bold; text-decoration: none; font-size: 12; color: #ff0000;" class="functions_built excel" href="javascript:void(0);"><img src="/images/excel.png" />&nbsp;<?php echo FSText::_('Xuất báo cáo ra file Excel')?></a>
</div><!--end: .tbpopup-content-->
<script type="text/javascript">
$(document).ready(function(){
    $('#tbl-report-city .export_sales').val('11');
});
</script>