import java.util.*;

public class GenerateOrders implements Runnable {
	int Time;
	List<Order> OutputList = new LinkedList<>();
	Credentials customers = new Credentials();
	ShoppingCart Cart1 = new ShoppingCart<Device>();
	ShoppingCart Cart2 = new ShoppingCart<Device>();
	ShoppingCart Cart3 = new ShoppingCart<Device>();
	ShoppingCart Cart4 = new ShoppingCart<Device>();
	Phone ph1 = new Phone("2","Бревнофон","300","Икея","Бревнофон 3000","Бревноид 1.1","Классический","резерв");
	SmartPhone sph1 = new SmartPhone("1","Унитазофон","24000","Индус-прошивка","Унитазофон 2017","Шишдовз визда","Обычная","1");
	Book bk1 = new Book("1","Доска деревянная","50","Димон ик","Доска 2018","Скоро будет","Доска на пеньке","900х1200");
	Phone ph2 = new Phone("3","Nokia","12000","Nokia","Nokia 4","Android","Классический","резерв");
	Book bk2 = new Book("2","NovaBook","55000","Green Gecko","Nova X","GeckOS","CycluraIntegral","900х1200");		
	Phone ph3 = new Phone("5","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","резерв");
	Book bk3 = new Book("5","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО");
	Phone ph4 = new Phone("1","МОНОЛИТ","350000","Циклура","УДАЛЕНО","УДАЛЕНО","Классический","резерв");
	SmartPhone sph4 = new SmartPhone("1","Артемида","600000","УДАЛЕНО","Артемида УДАЛЕНО","УДАЛЕНО","Обычная","УДАЛЕНО");
	Book bk4 = new Book("1","Прототип 33460","500000","Циклура","33460 2018","СЕКРЕТНО","СЕКРЕТНО","4000х4000");
	//Thread thread;			
	
	GenerateOrders(int m_time) {
		customers.AddUser("Katya","Iwanova","Petrovna","katya@gmail.com");
		customers.AddUser("Ivan","Voznyuk","Vyacheslavovich","ivan@stonejungle.org");
		customers.AddUser("Ivan","Hromov","Stepanovich","СЕКРЕТНО");
		customers.AddUser("Janna","Rasputin","Michailovna","janna@gmail.com");		
		//thread = new Thread(this, "Поток генерации заказов");
		//thread.start();
											
		Time = m_time;
	}
	@Override
	public void run() {	
	 try{
			Thread.sleep(Time);
			Cart1.add(ph1);
			Cart1.add(sph1);
			Cart1.add(bk1);
			this.OutputList.add(new Order(Cart1,customers,0));			
			Thread.sleep(Time);
			Cart2.add(ph2);
			Cart2.add(bk2);
			this.OutputList.add(new Order(Cart2,customers,1));
			Thread.sleep(Time);	
			Cart3.add(ph3);
			Cart3.add(bk3);
			this.OutputList.add(new Order(Cart3,customers,2));
			Thread.sleep(Time);
			Cart4.add(ph4);
			Cart4.add(sph4);
			Cart4.add(bk4);	
			this.OutputList.add(new Order(Cart4,customers,3));				
	 }
	 catch(InterruptedException e){
		System.out.println("Thread has been interrupted");
	 }	 
	}	
}
