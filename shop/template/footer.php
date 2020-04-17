<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
<script>

        function add_to_cart(good_id, price){
            <?php if (! (isset($is_cart) && $is_cart) ) { ?>
            let count_element = document.getElementById('count');
            <?php } else { ?>
            let count_element = document.getElementById('count_'+good_id);
            <?php } ?>

            let count = 1;
            if (count_element != null) {
                count = parseInt(count_element.value);
            }

            <?php if (! (isset($is_cart) && $is_cart) ) { ?>
            let old_count = 0;
            if(Cookies.get('cart['+good_id+']') != null) {
                storedCart = JSON.parse(Cookies.get('cart['+good_id+']'));
                old_count = storedCart[0];
                console.log(old_count);
            }
            count += parseInt(old_count);
            <?php } ?>

            Cookies.set('cart['+good_id+']', JSON.stringify([count, price]));

            //Обновляем общее количество и сумму
            let cookies_set = getCookieByMatch(/^cart/);
            console.log(cookies_set);
            let total_count = 0;
            let total_sum = 0;
            for (i=0; i<cookies_set.length; i++) {
                let item = cookies_set[i].split('=');
                let data = JSON.parse(item[1]);
                console.log(data[0]);
                console.log(data[1]);
                total_count += data[0];
                total_sum += data[0]*data[1];
            }
            document.getElementById('cart_count').innerText = 'Товаров всего: '+total_count+',';
            document.getElementById('cart_sum').innerText = 'Сумма: '+total_sum+' руб';
        }

        var getCookieByMatch = function(regex) {
            var cs=document.cookie.split(/;\s*/), ret=[], i;
            for (i=0; i<cs.length; i++) {
                if (cs[i].match(regex)) {
                    ret.push(cs[i]);
                }
            }
            return ret;
        };

        function delete_from_cart(good_id)
        {
            if(Cookies.get('cart['+good_id+']') != null) {
                Cookies.remove('cart['+good_id+']');
            }

            let element = document.getElementById('item_'+good_id);

            if (element != null) {
                element.remove();
            }

            //Обновляем общее количество и сумму
            let cookies_set = getCookieByMatch(/^cart/);
            console.log(cookies_set);
            let total_count = 0;
            let total_sum = 0;
            for (i=0; i<cookies_set.length; i++) {
                let item = cookies_set[i].split('=');
                let data = JSON.parse(item[1]);
                console.log(data[0]);
                console.log(data[1]);
                total_count += data[0];
                total_sum += data[0]*data[1];
            }
            document.getElementById('cart_count').innerText = 'Товаров всего: '+total_count+',';
            document.getElementById('cart_sum').innerText = 'Сумма: '+total_sum+' руб';
        }
</script>


</body>
</html>