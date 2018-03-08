<?php
global $tmpl;
$tmpl->addStylesheet('default', 'modules/home/assets/css');
$tmpl->addScript('highcharts', 'libraries/jquery/highcharts');
$tmpl->addScript('exporting', 'libraries/jquery/highcharts');
?>
<div class="event-title">
    <?php if($_SESSION['lang'] == 'vi'){ ?>
        Giới thiệu về Chương trình & Hệ thống Dữ liệu phục vụ Theo dõi, Đánh giá và Chia sẻ kinh nghiệm
    <?php }else{ ?>
        Introduction about the SECO/VIETRADE Program and the Database for Monitoring and Evaluation and the sharing of experiences
    <?php } ?>
</div><!--end: .event-title-->
<div class="content-inner clearfix">
    <?php if($_SESSION['lang'] == 'vi'){ ?>
        <p>Cục Xúc tiến thương mại (XTTM) là đơn vị trực thuộc Bộ Công thương, thực hiện các chức năng quản lý Nhà nước về XTTM, định hướng và tổ chức công tác XTTM, trong đó có chức năng thực hiện hợp tác quốc tế về XTTM. Hiện tại, Cục đang triển khai một số chương trình và dự án với phạm vi cả nước như Chương trình XTTM quốc gia, Chương trình Thương hiệu quốc gia, Chương trình hỗ trợ doanh nghiệp nhỏ và vừa (DNNVV), v.v…</p>
        <p>Với mục tiêu nâng cao sự đóng góp của các DNNVV trong lĩnh vực xuất khẩu tại 3 vùng được lựa chọn (Miền Bắc, Miền Trung, và Tây Nam Bộ) thông qua việc nâng cao hiệu quả các dịch vụ hỗ trợ thương mại cho các doanh nghiệp xuất khẩu tiềm năng ở cấp vùng và địa phương, Cục XTTM đang thực hiện Chương trình “Nâng cao năng lực cạnh tranh xuất khẩu cho các DNNVV Việt Nam thông qua hệ thống XTTM địa phương”. Đây là một chương trình hợp tác kỹ thuật do Chính phủ Thụy Sỹ tài trợ thông qua Cục kinh tế Liên bang Thụy Sĩ (SECO) với thời gian triển khai là từ năm 2014 đến 2017. Mục tiêu của chương trình được thực hiện thông qua việc nâng cao năng lực kỹ thuật của các Trung tâm XTTM, các tổ chức hỗ trợ thương mại và hiệp hội ngành hàng địa phương được lựa chọn với vai trò là các tổ chức hỗ trợ cho các DNNVV xuất khẩu trong khuôn khổ hoạt động của 3 mạng lưới hỗ trợ thương mại vùng.</p>  
        <p>Hệ thống cơ sở dữ liệu này được xây dựng để hỗ trợ công tác Theo dõi, Đánh giá Chương trình và quan trọng hơn cả là để hỗ trợ các cơ quan XTTM, các doanh nghiệp trong và ngoài Chương trình chia sẻ kinh nghiệm hoạt động. Hệ thống này có thể được sử dụng cho cả các chương trình XTTM tương tự khác và các tỉnh không nằm trong dự án. Chi tiết thông tin và hướng dẫn sử dụng hệ thống xin được tải <a href="http://m-e.vietrade.gov.vn/docs/Gioi-thieu-He-thong-TD-DG-Mang-luoi-XTTM.doc">tại đây</a></p>
    <?php }else{ ?>
        <p>The Vietnam Trade Promotion Agency (VIETRADE), Ministry of Industry and Trade, is a governmental organization responsible for state regulation of trade promotion, guiding and organizing trade promotion activities, including international cooperation in trade promotion. Currently, VIETRADE is implementing some nation-wide programs and projects such as the National Trade Promotion Program, the National Branding Program, the SMEs support Program, etc.</p>
        <p>In order to upgrade the contribution of SMEs to exports in 3 selected regions (ie. the North, the Centre and the Southwest) through improving trade support services to potential exporting companies in those regions, VIETRADE is implementing the Program “Increasing the export competitiveness of Vietnamese SMEs through decentralized trade support services”.</p>
        <p>This is a technical cooperation program financed by the Swiss government through the State Secretariat for Economic Affairs (SECO) for a four-year duration from 2014 to 2017. The overall objective of the Program is to strengthen the technical capacity of selected Provincial Trade Promotion Organisations (TPOs), Trade Support Institutions (TSIs) and Product Associations in their trade supporting role of exporting SMEs. </p>
        <p>This database is built to support the Monitoring & Evalluation (M&E) system of the Program and also to support TPOs, enterprises involved and not involved in the Program, to share their experiences. This system can also be used for similar trade promotion programs and by entreprises/organizations in regions or provinces not included in the Program. For further information and to download the instruction manual, please <a href="http://m-e.vietrade.gov.vn/docs/Gioi-thieu-He-thong-TD-DG-Mang-luoi-XTTM.doc">click here</a>.</p>
    <?php } ?>
    <p><b><?php echo FSText::_('Tính đến nay, chương trình đã triển khai trên cả nước với 5 ngành hàng(1)')?></b></p>
    <div class="home-left">
        <div id="statistics_cities" style="height: 510px; width: 355px; border: 1px solid #888888;" class="sys-chart">
            
        </div>
        <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
        		type : 'POST',
                dataType: 'json',
        		url : '/index.php?module=home&view=home&raw=1&task=get_statistics_cities',
                success : function($json){
                    $('#statistics_cities').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '<?php echo FSText::_('Biểu đồ 1- Số TT, hiệp hội tham gia theo 3 vùng')?>'
                        },
                        subtitle: {
                            text: '<?php echo FSText::_('Gia tăng theo từng quý')?>'
                        },
                        xAxis: {
                            categories: $json.categories,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '<?php echo FSText::_('Số TT, Hiệp hội tham gia')?>'
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
        <div id="statistics_business" style="height: 510px; width: 355px; border: 1px solid #888888; margin-left: 20px;" class="sys-chart">
            
        </div>
        <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
        		type : 'POST',
                dataType: 'json',
        		url : '/index.php?module=home&view=home&raw=1&task=get_statistics_business',
                success : function($json){
                    $('#statistics_business').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: '<?php echo FSText::_('Biểu đồ 2- Số DNNVV tham gia theo 3 vùng')?>'
                        },
                        subtitle: {
                            text: '<?php echo FSText::_('Gia tăng theo từng quý')?>'
                        },
                        xAxis: {
                            categories: $json.categories,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: '<?php echo FSText::_('Số DNNVV tham gia')?>'
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
        <!--<img src="/images/demo/home-chart.jpg" />-->
        <table class="data-table">
            <tr class="bg-yellow white">
                <td colspan="7"><?php echo FSText::_('BẢNG TỔNG HỢP CÁC KẾT QUẢ CỦA CHƯƠNG TRÌNH (Tính đến hết quý')?> <?php echo $quarter['text'] ?>)</td>
            </tr>
            <tr class="blue">
                <td></td>
                <td class="w80px bg-gray bold center"><?php echo FSText::_('Bắc')?></td>
                <td class="w80px bg-gray bold center"><?php echo FSText::_('Trung')?></td>
                <td class="w80px bg-gray bold center"><?php echo FSText::_('Nam')?></td>
                <td class="w80px bg-gray bold center"><?php echo FSText::_('Cá ngừ')?></td>
                <td class="w80px bg-gray bold center"><?php echo FSText::_('Quả vải')?></td>
                <td class="w80px bg-gray bold center"><?php echo FSText::_('Chè xanh')?></td>
            </tr>
            <tr>
                <td><?php echo FSText::_('Số tỉnh xây dựng và hoàn thiện cơ sở dữ liệu quản lý khách')?> </td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
            </tr>
            <tr>
                <td><?php echo FSText::_('Số tỉnh triển khai khảo sát nhu cầu DN')?> </td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
                <td class="w80px"></td>
            </tr>
            <tr>
                <td><?php echo FSText::_('Tăng trưởng doanh thu xuất khẩu của các DNNVV tham gia chương trình')?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[1]['export_sales'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[2]['export_sales'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[3]['export_sales'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[4]['export_sales'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[1]['export_sales'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[2]['export_sales'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td><?php echo FSText::_('Tổng số thị trường mới mở')?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[1]['new_markets'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[2]['new_markets'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[3]['new_markets'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[4]['new_markets'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[1]['new_markets'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[2]['new_markets'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td><?php echo FSText::_('Tổng số khách hàng mới')?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[1]['new_clients'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[2]['new_clients'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrRegion[3]['new_clients'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[4]['new_clients'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[1]['new_clients'], 0, ',', '.'); ?></td>
                <td class="w80px" style="text-align: right;"><?php echo number_format($arrIndustries[2]['new_clients'], 0, ',', '.'); ?></td>
            </tr>
        </table>
    </div><!--end: .home-left-->
    <div class="home-right">
        <img src="/images/demo/map.jpg" />
    </div><!--end: .home-right-->
</div><!--end: .content-inner-->
<input type="hidden" id="data-role" value="home" />