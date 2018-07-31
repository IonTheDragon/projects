import java.util.*;

public class Shop {
	public static void main (String args[])  throws InterruptedException  {
			System.out.println("Создание покупателей и корзины");	
			Orders orders = new Orders<Order>();
			
			Credentials customers = new Credentials();
			customers.AddUser("Ashot","Galustyan","Vaganych","armen@mail.am"); 
			customers.AddUser("Stas","Hrenov","Petrovich","hrenoff@mail.ru");  //HashSet сортирует по алфавиту, т.е. Иван будет вторым
			customers.AddUser("Ivan","Rasputin","Nikolaevich","ivrs@gmail.com");

			ShoppingCart Cart1 = new ShoppingCart<Device>();
			Phone ph1 = new Phone("2","Хсяомя","3500","Джамшут дистрибутив","Хсяомя Хэ","Ведроид 2.0","Классический","резерв");
			SmartPhone sph1 = new SmartPhone("1","Унитазофон","25000","Индус-прошивка","Унитазофон 2018","Шишдовз визда","Обычная","2");
			Book bk1 = new Book("1","ПакетБука","33000","Гараж Васяна","Планшет 3000 элитный","Макось с таблэткой","Пенек","900х1200");						
			Cart1.add(ph1);
			Cart1.add(sph1);
			Cart1.add(bk1);
			Order FirstOrder = new Order(Cart1,customers,0);
			orders.Buy(FirstOrder);
			
			ShoppingCart Cart2 = new ShoppingCart<Device>();
			Phone ph2 = new Phone("2","Nokia","15000","Nokia","Nokia 777","Android","Классический","резерв");
			Book bk2 = new Book("2","NovaBook","25000","Green Gecko","Nova 18","GeckOS","Intel","900х1200");
			Cart2.add(ph2);
			Cart2.add(bk2);
			Order SecondOrder = new Order(Cart2,customers,1);
			orders.Buy(SecondOrder);
			
			ShoppingCart Cart3 = new ShoppingCart<Device>();
			Phone ph3 = new Phone("1","Nokia","10000","Nokia","Nokia 15","Android","Раскладушка","резерв");
			SmartPhone sph2 = new SmartPhone("1","IPhone","55000","Apple","IPhone X","MacOS","Multi-Sim","2");
			Cart3.add(ph3);
			Cart3.add(sph2);	
			Order ThirdOrder = new Order(Cart3, customers, 2);			
			orders.Buy(ThirdOrder);
			
			GenerateOrders GenThread = new GenerateOrders(5000,orders);
			Validate ValThread = new Validate(10000,5,orders,"Auto");
			DeleteValidatedOrders DelThread = new DeleteValidatedOrders(15000,3,orders,"Auto");
			Thread t1 = new Thread(GenThread);
			Thread t2 = new Thread(ValThread);
			Thread t3 = new Thread(DelThread);
			t1.start();
			t2.start();
			t3.start();
			
			orders.show();
			System.out.println("Ждем 7 сек");
			System.out.println("__________________");
			Thread.sleep(7000);	
			orders.show();
			System.out.println("Ждем 5 сек");
			System.out.println("__________________");
			Thread.sleep(5000);	
			orders.show();
			System.out.println("Ждем 10 сек");
			System.out.println("__________________");
			Thread.sleep(10000);	
			orders.show();	
			System.out.println("Ждем 10 сек");
			System.out.println("__________________");
			Thread.sleep(10000);	
			orders.show();									
	}
}
