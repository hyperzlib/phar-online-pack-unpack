var zan = {

	//初始化函数
	init: function() {
		this.dropDown();
		this.setImgHeight();
    this.addAnimation();
    this.goTop();
	},

	goTop: function() {
		jQuery(window).scroll(function() {
			jQuery(this).scrollTop() > 200 ? jQuery("#zan-gotop").css({
				bottom: "110px"
			}) : jQuery("#zan-gotop").css({
				bottom: "-110px"
			});
		});

		jQuery("#zan-gotop").click(function() {
			return jQuery("body,html").animate({
				scrollTop: 0
			}, 800), !1
		});
	},

	// 设置导航栏子菜单下拉交互
	dropDown: function() {
		var dropDownLi = jQuery('.nav.navbar-nav li');

		dropDownLi.mouseover(function() {
			jQuery(this).addClass('open');
		}).mouseout(function() {
			jQuery(this).removeClass('open');
		});
	},

	// 等比例设置文章图片高度
	setImgHeight: function() {
		var relatedImg = jQuery("#post-related .post-related-img img"),
		  	thumbImg = jQuery("#article-list .zan-thumb img"),
				articleImg = jQuery(".zan-article img");

		eachHeight(relatedImg);
		eachHeight(thumbImg);
		eachHeight(articleImg);

		function  eachHeight(data) {
			data.each(function() {
				var $this 		 = jQuery(this),
						attrWidth  = $this.attr('width'),
						attrHeight = $this.attr('height'),
						width 		 = $this.width(),
						scale      = width / attrWidth,
						height     = scale * attrHeight;

				$this.css('height', height);

			});
		}
	},

  // 为指定元素添加动态样式
  addAnimation: function() {
    var animations = jQuery("[data-toggle='animation']");

    animations.each(function() {
      jQuery(this).addClass("animation", 2000);
    });
  },


	
  

}

jQuery(function() {
	zan.init();
});
