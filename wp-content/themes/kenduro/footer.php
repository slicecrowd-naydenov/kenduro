<?php 
  use Lean\Load;
  Load::organism('footer/index');
  Load::organisms('modals/consent_banner/index');

  wp_footer(); 
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const btn = document.getElementById('load-more-products');
	const container = document.getElementById('ajax-products');
	const skeleton = document.getElementById('skeleton');
	
	if (!btn || !container) return;

	let page = parseInt(btn.dataset.page);
	let cat = container.dataset.category;
	let ids = container.dataset.ids;
	let term = container.dataset.term;
	let preloadHTML = '';
	document.body.style.overflow = 'hidden';

	function preloadNextPage() {
		// btn.disabled = true;
		// btn.innerText = 'Зареждане...';

		let currentParams = new URLSearchParams(window.location.search);

    currentParams.set('action', 'load_more_products');
    currentParams.set('page', page);
		currentParams.set('term', term);
		currentParams.set('taxonomy', 'pa_brand');
    currentParams.set('category', cat);
    currentParams.set('ids', ids);


    fetch('<?php echo admin_url('admin-ajax.php'); ?>?' + currentParams.toString())
			.then(response => response.text())
			.then(html => {
        console.log('html: ', html.trim().length);
				if (html.trim().length < 100) {
					// console.log('махаме го');
					// btn.remove();
					btn.classList.add('hide');
				} else {
					// container.insertAdjacentHTML('beforeend', html);
					preloadHTML = html.trim();
					btn.dataset.page = page;
					btn.disabled = false;
					btn.innerText = 'Зареди още';
					btn.classList.remove('hide');
				}
        // skeleton.style.opacity = 0;
				// skeleton.classList.add("hide");
				document.body.style.overflow = 'inherit';
				// skeleton.classList.add("hide");
			});
	}

	function resetAfterFilter() {
		page = 2;
		preloadHTML = '';
		cat = container.dataset.category;
		ids = container.dataset.ids;
		term = container.dataset.term;
		preloadNextPage();
	}


	btn.addEventListener('click', function () {
		const hiddenProducts = container.querySelectorAll('ul.products > li.product[style*="display: none"]');

		if (hiddenProducts.length > 0) {
			hiddenProducts.forEach(el => el.style.display = '');
			page++;
			btn.dataset.page = page;
			btn.disabled = true;
			btn.innerText = 'Зареди още';
			preloadNextPage();
		} else if (preloadHTML.length > 0) {
			const tempDiv = document.createElement('div');
			tempDiv.innerHTML = preloadHTML;

			// просто добавяме без да крием нищо
			const newContent = tempDiv.querySelector('.woocommerce');
			if (newContent) container.appendChild(newContent);

			page++;
			btn.dataset.page = page;
			preloadHTML = '';
			btn.disabled = true;
			btn.innerText = 'Зареди още';
			preloadNextPage();
		}

		// preloadNextPage();
	});

	document.querySelectorAll('.wpfMainWrapper li, .wpfMainWrapper .wpfBlockClear').forEach(function (el) {
		el.addEventListener('click', function () {
			container.style.minHeight = '1080px';
			skeleton.classList.remove("hide");
			btn.classList.add("hide");
      // skeleton.style.opacity = 1;
			document.body.style.overflow = 'hidden';
			const scrollTarget = document.getElementById('primary');
			const ajaxProducts = document.getElementById('ajax-products');
			const loadMoreBtn = document.getElementById('load-more-products');

			// Smooth scroll до #primary
			scrollTarget.scrollIntoView({ behavior: 'smooth' });
			
			// След 500ms (приблизителна продължителност на scroll)
			setTimeout(function () {
				const productLists = ajaxProducts.querySelectorAll('.products');
				productLists.forEach(ul => ul.innerHTML = '');
				
				if (loadMoreBtn) {
					loadMoreBtn.setAttribute('data-page', '1');
					resetAfterFilter();
				}
			}, 500);
		});
	});

	page++
	preloadNextPage();
	skeleton.classList.add("hide");
	document.body.style.overflow = 'inherit';
});
</script>
<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/65f84698cc1376635adbd434/1hp8t7gvr';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->

</body>
</html>
