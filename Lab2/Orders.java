import java.util.Date;
import java.util.*;

public class Orders {	

	List<Object> OrdersList = new LinkedList<>();
	Map<Date, List<? extends Object>> LimitedItems = new HashMap<>();	

	public void Buy(Order m_order) {
		List<Object> lim_orders = new LinkedList<>();
		this.OrdersList.add(m_order);
		lim_orders.add(m_order);
		this.LimitedItems.put(m_order.CreationTime, lim_orders);	//запись текущего заказа с временем в список временного хранения	
	}
	
	public void show() {
			 
	for (int i = 0; i < OrdersList.size(); i++) {
		System.out.println("________________________");	
		Order m_order = (Order)OrdersList.get(i);
		ArrayList<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;
		Object[][] data = new Object[10][m_PurchasingItemsList.size()];
		for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
			if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Phone") {
				Phone phone = (Phone)m_PurchasingItemsList.get(j);
				data[0][j] = "Phone";
				data[1][j] = phone.GetId().toString();
				data[2][j] = phone.GetCount();
				data[3][j] = phone.GetName();
				data[4][j] = phone.GetPrice();
				data[5][j] = phone.GetCompany();
				data[6][j] = phone.GetModel();
				data[7][j] = phone.GetOs();
				data[8][j] = phone.GetParam1();
				data[9][j] = "";
				System.out.println("Идентификатор: "+data[1][j]);
				System.out.println("Тип устройства: "+data[0][j]);
				System.out.println("Количество: "+data[2][j]);
				System.out.println("Название: "+data[3][j]);
				System.out.println("Цена: "+data[4][j]);
				System.out.println("Изготовитель: "+data[5][j]);
				System.out.println("Модель: "+data[6][j]);
				System.out.println("ОС: "+data[7][j]);
				System.out.println("Тип корпуса: "+data[8][j]);	
				System.out.println("________________________");			
			}
			else if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="SmartPhone") {
				SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
				data[0][j] = "Smartphone";
				data[1][j] = smphone.GetId().toString();
				data[2][j] = smphone.GetCount();
				data[3][j] = smphone.GetName();
				data[4][j] = smphone.GetPrice();
				data[5][j] = smphone.GetCompany();
				data[6][j] = smphone.GetModel();
				data[7][j] = smphone.GetOs();
				data[8][j] = smphone.GetParam1();
				data[9][j] = smphone.GetParam2();
				System.out.println("Идентификатор: "+data[1][j]);
				System.out.println("Тип устройства: "+data[0][j]);
				System.out.println("Количество: "+data[2][j]);
				System.out.println("Название: "+data[3][j]);
				System.out.println("Цена: "+data[4][j]);
				System.out.println("Изготовитель: "+data[5][j]);
				System.out.println("Модель: "+data[6][j]);
				System.out.println("ОС: "+data[7][j]);
				System.out.println("Тип SIM-карты: "+data[8][j]);
				System.out.println("Число SIM-карт: "+data[9][j]);
				System.out.println("________________________");		
			}  
			else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Book") {
				Book book = (Book)m_PurchasingItemsList.get(j);
				data[0][j] = "Book";
				data[1][j] = book.GetId().toString();
				data[2][j] = book.GetCount();
				data[3][j] = book.GetName();
				data[4][j] = book.GetPrice();
				data[5][j] = book.GetCompany();
				data[6][j] = book.GetModel();
				data[7][j] = book.GetOs();
				data[8][j] = book.GetParam1();
				data[9][j] = book.GetParam2();
				System.out.println("Идентификатор: "+data[1][j]);
				System.out.println("Тип устройства: "+data[0][j]);
				System.out.println("Количество: "+data[2][j]);
				System.out.println("Название: "+data[3][j]);
				System.out.println("Цена: "+data[4][j]);
				System.out.println("Изготовитель: "+data[5][j]);
				System.out.println("Модель: "+data[6][j]);
				System.out.println("ОС: "+data[7][j]);
				System.out.println("Процессор: "+data[8][j]);
				System.out.println("Разрешение экрана: "+data[9][j]);
				System.out.println("________________________");	
			}	
		}
				System.out.println("Заказчик");	
				User user = m_order.OurUser;
				user.ReadUser();
				System.out.println("________________________");	
				System.out.println("Статус");	
				System.out.println(m_order.Status);	
				System.out.println("________________________");			
	 }
	}	
	
	public void checkLimitation() { 
	System.out.println("Проверка заказа");
 // Pass 1 - collect delete candidates		
	List<Object> deleteOrders = new LinkedList<>();	
	Date CurrentTime = new Date();
	long CurrentTimeMls = CurrentTime.getTime();		
	long pastTime = 0;
	int needDelete = 0;
	String status = "";
	// Получаем набор элементов
	
	for(Date date : LimitedItems.keySet()){
		for (Object item : LimitedItems.get(date)){	
			Order currentItem = (Order)item;
			pastTime=CurrentTimeMls-currentItem.WaitingTime;
			status = currentItem.Status;	
			if (date.getTime()<=pastTime) {	
				if ("Обработан".equalsIgnoreCase(status)) {
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
		
	for (int i = 0; i < deleteOrders.size(); i++) {
		System.out.println("________________________");	
		Order m_order = (Order)deleteOrders.get(i);
		ArrayList<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;
		Object[][] data = new Object[10][m_PurchasingItemsList.size()];
		for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
			if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Phone") {
				Phone phone = (Phone)m_PurchasingItemsList.get(j);
				data[0][j] = "Phone";
				data[1][j] = phone.GetId().toString();
				data[2][j] = phone.GetCount();
				data[3][j] = phone.GetName();
				data[4][j] = phone.GetPrice();
				data[5][j] = phone.GetCompany();
				data[6][j] = phone.GetModel();
				data[7][j] = phone.GetOs();
				data[8][j] = phone.GetParam1();
				data[9][j] = "";
				System.out.println("Идентификатор: "+data[1][j]);
				System.out.println("Тип устройства: "+data[0][j]);
				System.out.println("Количество: "+data[2][j]);
				System.out.println("Название: "+data[3][j]);
				System.out.println("Цена: "+data[4][j]);
				System.out.println("Изготовитель: "+data[5][j]);
				System.out.println("Модель: "+data[6][j]);
				System.out.println("ОС: "+data[7][j]);
				System.out.println("Тип корпуса: "+data[8][j]);	
				System.out.println("________________________");			
			}
			else if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="SmartPhone") {
				SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
				data[0][j] = "Smartphone";
				data[1][j] = smphone.GetId().toString();
				data[2][j] = smphone.GetCount();
				data[3][j] = smphone.GetName();
				data[4][j] = smphone.GetPrice();
				data[5][j] = smphone.GetCompany();
				data[6][j] = smphone.GetModel();
				data[7][j] = smphone.GetOs();
				data[8][j] = smphone.GetParam1();
				data[9][j] = smphone.GetParam2();
				System.out.println("Идентификатор: "+data[1][j]);
				System.out.println("Тип устройства: "+data[0][j]);
				System.out.println("Количество: "+data[2][j]);
				System.out.println("Название: "+data[3][j]);
				System.out.println("Цена: "+data[4][j]);
				System.out.println("Изготовитель: "+data[5][j]);
				System.out.println("Модель: "+data[6][j]);
				System.out.println("ОС: "+data[7][j]);
				System.out.println("Тип SIM-карты: "+data[8][j]);
				System.out.println("Число SIM-карт: "+data[9][j]);
				System.out.println("________________________");		
			}  
			else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Book") {
				Book book = (Book)m_PurchasingItemsList.get(j);
				data[0][j] = "Book";
				data[1][j] = book.GetId().toString();
				data[2][j] = book.GetCount();
				data[3][j] = book.GetName();
				data[4][j] = book.GetPrice();
				data[5][j] = book.GetCompany();
				data[6][j] = book.GetModel();
				data[7][j] = book.GetOs();
				data[8][j] = book.GetParam1();
				data[9][j] = book.GetParam2();
				System.out.println("Идентификатор: "+data[1][j]);
				System.out.println("Тип устройства: "+data[0][j]);
				System.out.println("Количество: "+data[2][j]);
				System.out.println("Название: "+data[3][j]);
				System.out.println("Цена: "+data[4][j]);
				System.out.println("Изготовитель: "+data[5][j]);
				System.out.println("Модель: "+data[6][j]);
				System.out.println("ОС: "+data[7][j]);
				System.out.println("Процессор: "+data[8][j]);
				System.out.println("Разрешение экрана: "+data[9][j]);
				System.out.println("________________________");	
			}	
		}
				System.out.println("Заказчик");	
				User user = m_order.OurUser;
				user.ReadUser();
				System.out.println("________________________");			
	 }		
		
		//		
				
// Pass 2 - delete

		for (Object deleteOrder : deleteOrders) {		
			OrdersList.remove(deleteOrder);
		}		
	}	
	
    } 
}
