<?php
/**
 * 阿里图床
 *
 * @package custom
 */
?>

<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
	<script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
	<link href="https://cdn.bootcss.com/mdui/0.4.3/css/mdui.min.css" rel="stylesheet">
	<script src="https://cdn.bootcss.com/mdui/0.4.3/js/mdui.min.js"></script>
	<link rel="stylesheet" href="<?php $this->options->themeUrl('assets/file-input/css/fileinput.min.css'); ?>">
	<script src="<?php $this->options->themeUrl('assets/file-input/js/fileinput.min.js'); ?>"></script>
	<script src="<?php $this->options->themeUrl('assets/file-input/js/locales/zh.js'); ?>"></script>
<body class="mdui-theme-primary-indigo mdui-theme-accent-green">
	<div class="mdui-progress">
		<div class="mdui-progress-indeterminate mdui-color-pink-a400" id="loading" style="display: none;"></div>
	</div>
	<div class="mdui-container">
		<div class="mdui-row">
			<div class="mdui-col-md-8 mdui-col-offset-md-2">
				 <div class="card-header card-header-primary">
                            <?php $this->options->title()?>专用图床  - AliCDN提供支持
                        </div>
					<input name="file" id="input-id" type="file" multiple>
					<div class="mdui-table-fluid">
						<table class="mdui-table">
							<tbody id="urls"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$("#input-id").fileinput({
			language:'zh',
            uploadUrl: '<?php $this->options->themeUrl('upload.php'); ?>',
            uploadAsync: true,
			maxFileCount: 5,
			showClose: false,
			allowedFileExtensions: ["jpeg", "jpg", "png", "gif", "ico"]
		});
		$('#input-id').on('fileuploaded', function(event, data, previewId, index) {
			console.log(data.response.url);
			$('#urls').append('<tr><td width="180"><img class="mdui-img-fluid" src="'+data.response.url+'"/></td><td><div class="mdui-textfield"><label class="mdui-textfield-label">Url</label><input class="mdui-textfield-input" type="text" value="'+data.response.url+'"/></div></td></tr>');
		});
		$('#input-id').on('filecleared', function(event) {
			console.log("filecleared");
			$('#urls').html('');
		});
	</script>
<footer class="footer">
        <hr>
        <div class="row align-items-center justify-content-md-between">
            <div class="col-md-12 ">
                <ul class="nav nav-footer justify-content-center">
                    <?php echo $this->options->social_links; ?>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="copyright text-center">
              <p id="htmer_time"></p>
                    &copy; <?php _e(date('Y')) ?>
                    <a href="<?php $this->options->siteUrl() ?>" target="_blank"><?php $this->options->title() ?> </a>.
                    本图床插件由本站开发 页面加载耗时:<?php _e(timer_stop()) ?>
                    <div style="display:none;">
                        <?php  _e($this->options->social_script)?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="lolijump">
    <img src="<?php $this->options->themeUrl('images/lolijump.gif') ?>">
</div>
<script language="javascript">
    $pageNavClass = $('.pagination li a');
    $pageNavClass.addClass('paging-link');
    lastScrollY = 0;
    function heartBeat0() {
        diffY = document.body.scrollTop;
        percent = .1 * (diffY - lastScrollY);
        if (percent > 0) percent = Math.ceil(percent);
        else percent = Math.floor(percent);
        document.all.lolijump.style.pixelTop += percent;
        lastScrollY = lastScrollY + percent;
    }

    window.setInterval("heartBeat0()", 1);
    $('#lolijump').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    });

</script>
<script>
function secondToDate(second) {
        if (!second) {
            return 0;
        }
        var time = new Array(0, 0, 0, 0, 0);
        if (second >= 365 * 24 * 3600) {
            time[0] = parseInt(second / (365 * 24 * 3600));
            second %= 365 * 24 * 3600;
        }
        if (second >= 24 * 3600) {
            time[1] = parseInt(second / (24 * 3600));
            second %= 24 * 3600;
        }
        if (second >= 3600) {
            time[2] = parseInt(second / 3600);
            second %= 3600;
        }
        if (second >= 60) {
            time[3] = parseInt(second / 60);
            second %= 60;
        }
        if (second > 0) {
            time[4] = second;
        }
        return time;
    }
    function setTime() {
   		 /*此处为网站的创建时间*/
        var create_time = Math.round(new Date(Date.UTC(2019, 12, 05, 15, 45, 15)).getTime() / 1000);
        var timestamp = Math.round((new Date().getTime() + 8 * 60 * 60 * 1000) / 1000);
        currentTime = secondToDate((timestamp - create_time));
        currentTimeHtml = '本站已运行：' + currentTime[1] + '天'
                + currentTime[2] + '时' + currentTime[3] + '分' + currentTime[4]
                + '秒';
        document.getElementById("htmer_time").innerHTML = currentTimeHtml;
    }
    setInterval(setTime, 1000);
    </script>
<script src="//cdn.staticfile.org/popper.js/1.7.0/popper.min.js"></script>
<script src="//cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="//cdn.staticfile.org/headroom/0.9.4/headroom.min.js"></script>
<script src="//cdn.staticfile.org/wow/1.0.1/wow.min.js"></script>
<script src="<?php $this->options->themeUrl('js/theme.js') ?>"></script>
<?php if($this->is('single')):?>
    <?php if($this->options->fancybox=='yes'):?>
    <script src="https://cdn.staticfile.org/fancybox/3.2.1/jquery.fancybox.min.js"></script>
    <?php endif;?>
<?php endif ?>
<?php $this->footer(); ?>
<?php
if($this->options->pjaxset=='yes'):?>
<script src="//cdn.staticfile.org/instantclick/3.1.0/instantclick.min.js" data-no-instant></script>
<script data-no-instant>
    InstantClick.init('mousedown');
</script>
<?php endif; ?>
</body>
</html>
