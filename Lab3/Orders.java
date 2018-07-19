import java.util.Date;
import java.util.*;

public class Orders<T extends Order> {	

	List<T> OrdersList = new LinkedList<>();
	Map<Date, List<? extends T>> LimitedItems = new HashMap<>();	

	public void Buy(T m_order) {
		List<T> lim_orders = new LinkedList<>();
		this.OrdersList.add(m_order);
		lim_orders.add(m_order);
		this.LimitedItems.put(m_order.CreationTime, lim_orders);	//запись текущего заказа с временем в список временного хранения	
	}
	
	public void show(List<T> m_OrdersList) {
			 
	for (int i = 0; i < m_OrdersList.size(); i++) {
		System.out.println("________________________");	
		T m_order = m_OrdersList.get(i);
		ArrayList<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;
		for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
			if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Phone") {
				Phone phone = (Phone)m_PurchasingItemsList.get(j);
				System.out.println("Идентификатор: "+phone.GetId().toString());
				System.out.println("Тип устройства: Phone");
				System.out.println("Количество: "+phone.GetCount());
				System.out.println("Название: "+phone.GetName());
				System.out.println("Цена: "+phone.GetPrice());
				System.out.println("Изготовитель: "+phone.GetCompany());
				System.out.println("Модель: "+phone.GetModel());
				System.out.println("ОС: "+phone.GetOs());
				System.out.println("Тип корпуса: "+phone.GetParam1());	
				System.out.println("________________________");			
			}
			else if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="SmartPhone") {
				SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
				System.out.println("Идентификатор: "+smphone.GetId().toString());
				System.out.println("Тип устройства: Smartphone");
				System.out.println("Количество: "+smphone.GetCount());
				System.out.println("Название: "+smphone.GetName());
				System.out.println("Цена: "+smphone.GetPrice());
				System.out.println("Изготовитель: "+smphone.GetCompany());
				System.out.println("Модель: "+smphone.GetModel());
				System.out.println("ОС: "+smphone.GetOs());
				System.out.println("Тип SIM-карты: "+smphone.GetParam1());
				System.out.println("Число SIM-карт: "+smphone.GetParam2());
				System.out.println("________________________");		
			}  
			else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Book") {
				Book book = (Book)m_PurchasingItemsList.get(j);
				System.out.println("Идентификатор: "+book.GetId().toString());
				System.out.println("Тип устройства: Book");
				System.out.println("Количество: "+book.GetCount());
				System.out.println("Название: "+book.GetName());
				System.out.println("Цена: "+book.GetPrice());
				System.out.println("Изготовитель: "+book.GetCompany());
				System.out.println("Модель: "+book.GetModel());
				System.out.println("ОС: "+book.GetOs());
				System.out.println("Процессор: "+book.GetParam1());
				System.out.println("Разрешение экрана: "+book.GetParam2());
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
	List<T> deleteOrders = new LinkedList<>();	
	Date CurrentTime = new Date();
	long CurrentTimeMls = CurrentTime.getTime();		
	long pastTime = 0;
	int needDelete = 0;
	String status = "";
	// Получаем набор элементов
	
	for(Date date : LimitedItems.keySet()){
		for (T item : LimitedItems.get(date)){	
			Order currentItem = item;
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
		
		this.show(deleteOrders);	
		
		//		
				
// Pass 2 - delete

		for (Object deleteOrder : deleteOrders) {		
			OrdersList.remove(deleteOrder);
		}		
	}	
	
    } 
}
