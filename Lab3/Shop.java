import java.util.*;

public class Shop {
	public static void main (String args[])  throws InterruptedException  {
			System.out.println("Создание покупателей и корзины");	
			ShoppingCart Cart1 = new ShoppingCart<Device>();
			Credentials customers = new Credentials();
			customers.AddUser("Ashot","Galustyan","Vaganych","armen@mail.am"); 
			customers.AddUser("Stas","Hrenov","Petrovich","hrenoff@mail.ru");  //HashSet сортирует по алфавиту, т.е. Иван будет вторым
			customers.AddUser("Ivan","Rasputin","Nikolaevich","ivrs@gmail.com");
			Phone ph1 = new Phone("2","Хсяомя","3500","Джамшут дистрибутив","Хсяомя Хэ","Ведроид 2.0","Классический","резерв");
			SmartPhone sph1 = new SmartPhone("1","Унитазофон","25000","Индус-прошивка","Унитазофон 2018","Шишдовз визда","Обычная","2");
			Book bk1 = new Book("1","ПакетБука","33000","Гараж Васяна","Планшет 3000 элитный","Макось с таблэткой","Пенек","900х1200");
			Cart1.add(ph1);
			Cart1.add(sph1);
			Cart1.add(bk1);
			System.out.println("Вывод заказа 2 пользователей");
			Orders orders = new Orders<Order>();
			Order FirstOrder = new Order(Cart1,customers,0,10000);
			FirstOrder.handle();
			orders.Buy(FirstOrder);
			ShoppingCart Cart2 = new ShoppingCart<Device>();
			Phone ph2 = new Phone("2","Nokia","15000","Nokia","Nokia 777","Android","Классический","резерв");
			Book bk2 = new Book("2","NovaBook","25000","Green Gecko","Nova 18","GeckOS","Intel","900х1200");
			Cart2.add(ph2);
			Cart2.add(bk2);
			Order SecondOrder = new Order(Cart2,customers,1,5000);
			SecondOrder.handle();
			orders.Buy(SecondOrder);
			orders.show(orders.OrdersList);
			orders.checkLimitation();
			System.out.println("Ждем 15 сек");
			Thread.sleep(15000);	
			System.out.println("Добавляем новый заказ и проверяем старые");
			ShoppingCart Cart3 = new ShoppingCart<Device>();
			Phone ph3 = new Phone("1","Nokia","10000","Nokia","Nokia 15","Android","Раскладушка","резерв");
			SmartPhone sph2 = new SmartPhone("1","IPhone","55000","Apple","IPhone X","MacOS","Multi-Sim","2");
			Cart3.add(ph3);
			Cart3.add(sph2);	
			Order ThirdOrder = new Order(Cart3, customers, 2,15000);
			ThirdOrder.handle();
			orders.Buy(ThirdOrder);	
			
			orders.checkLimitation();
			System.out.println("________________________");	
			System.out.println("Итоговый заказ");
			orders.show(orders.OrdersList);
	}
}
