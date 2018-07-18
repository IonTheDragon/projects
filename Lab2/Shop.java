import java.util.*;

public class Shop {
	public static void main (String args[])  throws InterruptedException  {
			System.out.println("Создание покупателей и корзины");	
			ShoppingCart Cart1 = new ShoppingCart();
			Credentials customers = new Credentials();
			customers.AddUser("Ashot","Galustyan","Vaganych","armen@mail.am"); 
			customers.AddUser("Stas","Hrenov","Petrovich","hrenoff@mail.ru");
			customers.AddUser("Ivan","Rasputin","Nikolaevich","ivrs@gmail.com");
			Cart1.add("phone","2","Хсяомя","3500","Джамшут дистрибутив","Хсяомя Хэ","Ведроид 2.0","Классический","резерв");
			Cart1.add("smartphone","1","Унитазофон","25000","Индус-прошивка","Унитазофон 2018","Шишдовз визда","Обычная","2");
			Cart1.add("book","1","ПакетБука","33000","Гараж Васяна","Планшет 3000 элитный","Макось с таблэткой","Пенек","900х1200");
			System.out.println("Вывод заказа 2 пользователей");
			Orders orders = new Orders();
			Order FirstOrder = new Order(Cart1,customers,0,10000);
			FirstOrder.handle();
			orders.Buy(FirstOrder);
			ShoppingCart Cart2 = new ShoppingCart();
			Cart2.add("phone","2","Nokia","15000","Nokia","Nokia 777","Android","Классический","резерв");
			Cart2.add("book","2","NovaBook","25000","Green Gecko","Nova 18","GeckOS","Intel","900х1200");
			Order SecondOrder = new Order(Cart2,customers,1,5000);
			SecondOrder.handle();
			orders.Buy(SecondOrder);
			orders.show(orders.OrdersList);
			System.out.println("Вывод идентификатора 2 товара 1 корзины");
			UUID id = Cart1.readId(1);
			System.out.println(id );
			System.out.println("Поиск 2 товара с использованием идентификатора");
			Cart1.search(id);
			orders.checkLimitation();
			System.out.println("Ждем 15 сек");
			Thread.sleep(15000);	
			System.out.println("Добавляем новый заказ и проверяем старые");
			ShoppingCart Cart3 = new ShoppingCart();
			Cart3.add("phone","1","Nokia","10000","Nokia","Nokia 15","Android","Раскладушка","резерв");
			Cart3.add("smartphone","1","IPhone","55000","Apple","IPhone X","MacOS","Multi-Sim","2");	
			Order ThirdOrder = new Order(Cart3, customers, 2,15000);
			ThirdOrder.handle();
			orders.Buy(ThirdOrder);	
			
			orders.checkLimitation();
			System.out.println("________________________");	
			System.out.println("Итоговый заказ");
			orders.show(orders.OrdersList);
	}
}
