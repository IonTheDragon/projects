import java.util.Date;
import java.util.*;

public class Order {
	String Status;
	Date CreationTime = new Date();
	long WaitingTime = 10000;//10 s
	List<Object> Orders = new LinkedList<>();
	ShoppingCart PurchasingItems = new ShoppingCart();
	Credentials Customers = new Credentials();
	Map<Date, List<? extends Object>> LimitedItems = new HashMap<>();
		
	public void Buy(ShoppingCart m_PurchasingItems, Credentials m_Customers, int Customer) {
		this.CreationTime = new Date();		
		this.PurchasingItems = m_PurchasingItems;
		ArrayList<Device> PurchasingItemsList = PurchasingItems.ShoppingCartList;
		this.Customers = m_Customers;
		User[] UsersArray = {};
		UsersArray = Customers.Users.toArray(new User[Customers.Users.size()]);
		User OurUser = UsersArray[Customer];
		List<Object> order = new LinkedList<>();
		for (int i = 0; i < PurchasingItemsList.size(); i++) {
			this.Orders.add(PurchasingItemsList.get(i));
			order.add(PurchasingItemsList.get(i));
		}
		this.Orders.add(OurUser);
		order.add(OurUser);
		this.LimitedItems.put(CreationTime, order);	//запись текущего заказа с временем в список временного хранения
		this.Status = "Ожидание";
	}
	
	public void show() {
		
	Object[][] data = new Object[10][Orders.size()];	 
	for (int i = 0; i < Orders.size(); i++) {
		System.out.println("________________________");	
		if (Orders.get(i).getClass().getSimpleName()=="Phone") {
			Phone phone = (Phone)Orders.get(i);
			data[0][i] = "Phone";
			data[1][i] = phone.GetId().toString();
			data[2][i] = phone.GetCount();
			data[3][i] = phone.GetName();
			data[4][i] = phone.GetPrice();
			data[5][i] = phone.GetCompany();
			data[6][i] = phone.GetModel();
			data[7][i] = phone.GetOs();
			data[8][i] = phone.GetParam1();
			data[9][i] = "";
			System.out.println("Идентификатор: "+data[1][i]);
			System.out.println("Тип устройства: "+data[0][i]);
			System.out.println("Количество: "+data[2][i]);
			System.out.println("Название: "+data[3][i]);
			System.out.println("Цена: "+data[4][i]);
			System.out.println("Изготовитель: "+data[5][i]);
			System.out.println("Модель: "+data[6][i]);
			System.out.println("ОС: "+data[7][i]);
			System.out.println("Тип корпуса: "+data[8][i]);			
		}
		else if (Orders.get(i).getClass().getSimpleName()=="SmartPhone") {
			SmartPhone smphone = (SmartPhone)Orders.get(i);
			data[0][i] = "Smartphone";
			data[1][i] = smphone.GetId().toString();
			data[2][i] = smphone.GetCount();
			data[3][i] = smphone.GetName();
			data[4][i] = smphone.GetPrice();
			data[5][i] = smphone.GetCompany();
			data[6][i] = smphone.GetModel();
			data[7][i] = smphone.GetOs();
			data[8][i] = smphone.GetParam1();
			data[9][i] = smphone.GetParam2();
			System.out.println("Идентификатор: "+data[1][i]);
			System.out.println("Тип устройства: "+data[0][i]);
			System.out.println("Количество: "+data[2][i]);
			System.out.println("Название: "+data[3][i]);
			System.out.println("Цена: "+data[4][i]);
			System.out.println("Изготовитель: "+data[5][i]);
			System.out.println("Модель: "+data[6][i]);
			System.out.println("ОС: "+data[7][i]);
			System.out.println("Тип SIM-карты: "+data[8][i]);
			System.out.println("Число SIM-карт: "+data[9][i]);	
		}  
		else if  (Orders.get(i).getClass().getSimpleName()=="Book") {
			Book book = (Book)Orders.get(i);
			data[0][i] = "Book";
			data[1][i] = book.GetId().toString();
			data[2][i] = book.GetCount();
			data[3][i] = book.GetName();
			data[4][i] = book.GetPrice();
			data[5][i] = book.GetCompany();
			data[6][i] = book.GetModel();
			data[7][i] = book.GetOs();
			data[8][i] = book.GetParam1();
			data[9][i] = book.GetParam2();
			System.out.println("Идентификатор: "+data[1][i]);
			System.out.println("Тип устройства: "+data[0][i]);
			System.out.println("Количество: "+data[2][i]);
			System.out.println("Название: "+data[3][i]);
			System.out.println("Цена: "+data[4][i]);
			System.out.println("Изготовитель: "+data[5][i]);
			System.out.println("Модель: "+data[6][i]);
			System.out.println("ОС: "+data[7][i]);
			System.out.println("Процессор: "+data[8][i]);
			System.out.println("Разрешение экрана: "+data[9][i]);
		}	
		else if (Orders.get(i).getClass().getSimpleName()=="User") {
			System.out.println("Заказчик");	
			User user = (User)Orders.get(i);
			data[0][i] = "Customer";
			data[1][i] = user.GetId().toString();
			data[2][i] = user.GetName();
			data[3][i] = user.GetSname();
			data[4][i] = user.GetFatherName();
			data[5][i] = user.GetMail();
			data[6][i] = "";
			data[7][i] = "";
			data[8][i] = "";
			data[9][i] = "";
			
			user.ReadUser();
			System.out.println("________________________");
			System.out.println("Статус заказа: "+Status);
		}		
	 }
	}	
	
	public void checkLimitation() { 
	System.out.println("Проверка заказа");
 // Pass 1 - collect delete candidates		
	List<Object> deleteOrders = new LinkedList<>();	
	Date CurrentTime = new Date();
	long CurrentTimeMls = CurrentTime.getTime();		
	long pastTime = CurrentTimeMls-WaitingTime;
	int needDelete = 0;
	// Получаем набор элементов
	
	for(Date date : LimitedItems.keySet()){
		for (Object item : LimitedItems.get(date)){		
			if (date.getTime()<=pastTime) {	
				if ("Обработан".equalsIgnoreCase(Status)) {
					needDelete = 1;
					deleteOrders.add(item);													
				}
			}	
		}
	}

	if (needDelete == 0) {
		System.out.println("________________________");	
		System.out.println("Нет обработанных заказов с истекшим сроком");		 
	}
	else {
		System.out.println("________________________");	
		System.out.println("Обработанные заказы с истекшим сроком");	
		
			// show deleting orders
		
			Object[][] data = new Object[10][deleteOrders.size()];	
			for (int i = 0; i < deleteOrders.size(); i++) {
				System.out.println("________________________");	
				if (deleteOrders.get(i).getClass().getSimpleName()=="Phone") {
					Phone phone = (Phone)deleteOrders.get(i);
					data[0][i] = "Phone";
					data[1][i] = phone.GetId().toString();
					data[2][i] = phone.GetCount();
					data[3][i] = phone.GetName();
					data[4][i] = phone.GetPrice();
					data[5][i] = phone.GetCompany();
					data[6][i] = phone.GetModel();
					data[7][i] = phone.GetOs();
					data[8][i] = phone.GetParam1();
					data[9][i] = "";
					System.out.println("Идентификатор: "+data[1][i]);
					System.out.println("Тип устройства: "+data[0][i]);
					System.out.println("Количество: "+data[2][i]);
					System.out.println("Название: "+data[3][i]);
					System.out.println("Цена: "+data[4][i]);
					System.out.println("Изготовитель: "+data[5][i]);
					System.out.println("Модель: "+data[6][i]);
					System.out.println("ОС: "+data[7][i]);
					System.out.println("Тип корпуса: "+data[8][i]);			
				}
				else if (deleteOrders.get(i).getClass().getSimpleName()=="SmartPhone") {
					SmartPhone smphone = (SmartPhone)deleteOrders.get(i);
					data[0][i] = "Smartphone";
					data[1][i] = smphone.GetId().toString();
					data[2][i] = smphone.GetCount();
					data[3][i] = smphone.GetName();
					data[4][i] = smphone.GetPrice();
					data[5][i] = smphone.GetCompany();
					data[6][i] = smphone.GetModel();
					data[7][i] = smphone.GetOs();
					data[8][i] = smphone.GetParam1();
					data[9][i] = smphone.GetParam2();
					System.out.println("Идентификатор: "+data[1][i]);
					System.out.println("Тип устройства: "+data[0][i]);
					System.out.println("Количество: "+data[2][i]);
					System.out.println("Название: "+data[3][i]);
					System.out.println("Цена: "+data[4][i]);
					System.out.println("Изготовитель: "+data[5][i]);
					System.out.println("Модель: "+data[6][i]);
					System.out.println("ОС: "+data[7][i]);
					System.out.println("Тип SIM-карты: "+data[8][i]);
					System.out.println("Число SIM-карт: "+data[9][i]);	
				}  
				else if  (deleteOrders.get(i).getClass().getSimpleName()=="Book") {
					Book book = (Book)deleteOrders.get(i);
					data[0][i] = "Book";
					data[1][i] = book.GetId().toString();
					data[2][i] = book.GetCount();
					data[3][i] = book.GetName();
					data[4][i] = book.GetPrice();
					data[5][i] = book.GetCompany();
					data[6][i] = book.GetModel();
					data[7][i] = book.GetOs();
					data[8][i] = book.GetParam1();
					data[9][i] = book.GetParam2();
					System.out.println("Идентификатор: "+data[1][i]);
					System.out.println("Тип устройства: "+data[0][i]);
					System.out.println("Количество: "+data[2][i]);
					System.out.println("Название: "+data[3][i]);
					System.out.println("Цена: "+data[4][i]);
					System.out.println("Изготовитель: "+data[5][i]);
					System.out.println("Модель: "+data[6][i]);
					System.out.println("ОС: "+data[7][i]);
					System.out.println("Процессор: "+data[8][i]);
					System.out.println("Разрешение экрана: "+data[9][i]);
				}	
				else if (deleteOrders.get(i).getClass().getSimpleName()=="User") {
					System.out.println("Заказчик");	
					User user = (User)deleteOrders.get(i);
					data[0][i] = "Customer";
					data[1][i] = user.GetId().toString();
					data[2][i] = user.GetName();
					data[3][i] = user.GetSname();
					data[4][i] = user.GetFatherName();
					data[5][i] = user.GetMail();
					data[6][i] = "";
					data[7][i] = "";
					data[8][i] = "";
					data[9][i] = "";
			
					user.ReadUser();
					System.out.println("________________________");
					System.out.println("Статус заказа: "+Status);
				}		
			}		
		
		//		
				
// Pass 2 - delete

		for (Object deleteOrder : deleteOrders) {		
			Orders.remove(deleteOrder);
		}		
	}	
	
    } 
    
    public void handle() {
		this.Status = "Обработан";
	}
	
}
			
