import java.util.*;
import java.io.*;

public class ManagerOrderFile extends AManageOrder {
	ManagerOrderFile(String m_path){
		super(m_path);
	}

	public void readById(UUID m_id){
		
        ArrayList<Order> readOrders = new ArrayList<Order>();
        try(ObjectInputStream ois = new ObjectInputStream(new FileInputStream(path)))
        {
             
            readOrders=((ArrayList<Order>)ois.readObject());
        }
        catch(Exception ex){
              
            System.out.println(ex.getMessage());
        }   
          
        for(Order o : readOrders)
        {
			if (o.OurUser.GetId()==m_id) {
				System.out.println("Заказчик\n"); 
				System.out.println("ID: "+o.OurUser.GetId()+"\n"); 
				System.out.println("Имя: "+o.OurUser.GetName()+"\n");   
				System.out.println("Фамилия: "+o.OurUser.GetSname()+"\n"); 
				System.out.println("Отчество: "+o.OurUser.GetFatherName()+"\n"); 
				System.out.println("Email: "+o.OurUser.GetMail()+"\n");
				System.out.println("__________\n");
			
				//ArrayList<Device> m_PurchasingItemsList = o.PurchasingItemsList;
				this.ShowDevices(o.PurchasingItemsList);
				break;
			}				
		} 
	  		
	}
	
	public void saveById(Orders m_orders, UUID m_id){

		//File m_file = new File(path);
		Order m_order = this.getOrderById(m_orders, m_id);
		
		try(ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(path))) {
			oos.writeObject(m_order);
		}
		catch(IOException e) {
			e.printStackTrace();
		}	
	}
	
	public void readAll(){
	  
        ArrayList<Order> readOrders = new ArrayList<Order>();
        try(ObjectInputStream ois = new ObjectInputStream(new FileInputStream(path)))
        {
             
            readOrders=((ArrayList<Order>)ois.readObject());
        }
        catch(Exception ex){
              
            System.out.println(ex.getMessage());
        } 
          
        for(Order o : readOrders)
        {
			System.out.println("Заказчик\n"); 
			System.out.println("ID: "+o.OurUser.GetId()+"\n"); 
            System.out.println("Имя: "+o.OurUser.GetName()+"\n");   
            System.out.println("Фамилия: "+o.OurUser.GetSname()+"\n"); 
			System.out.println("Отчество: "+o.OurUser.GetFatherName()+"\n"); 
			System.out.println("Email: "+o.OurUser.GetMail()+"\n");
			System.out.println("__________\n");
			
			//ArrayList<Device> m_PurchasingItemsList = o.PurchasingItemsList;
			this.ShowDevices(o.PurchasingItemsList);
		} 
	}
	
	public void saveAll(Orders m_orders){
	
		//File m_file = new File(path);
		try(ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(path))) {
			oos.writeObject(m_orders);
		}
		catch(Exception ex) {
			System.out.println(ex.getMessage());
		}	
	}
	
	public void ShowDevices(ArrayList<Device> m_PurchasingItemsList){
		for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
			if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Phone") {
				Phone phone = (Phone)m_PurchasingItemsList.get(j);
				//writer.write(phone.GetId().toString()+",Phone,"+phone.GetCount()+","+phone.GetName()+","+phone.GetPrice()+","+phone.GetCompany()+","+phone.GetModel()+","+phone.GetOs()+","+phone.GetParam1()+"\r\n");		
				System.out.println("Тип устройства - телефон\n"); 
				System.out.println("ID устройства: "+phone.GetId().toString()+"\n"); 
				System.out.println("Количество: "+phone.GetCount()+"\n"); 
				System.out.println("Название: "+phone.GetName()+"\n");   
				System.out.println("Цена: "+phone.GetPrice()+"\n"); 
				System.out.println("Производитель: "+phone.GetCompany()+"\n"); 
				System.out.println("Модель: "+phone.GetModel()+"\n");
				System.out.println("Система: "+phone.GetOs()+"\n");	
				System.out.println("Корпус: "+phone.GetParam1()+"\n");				 
			}
			else if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="SmartPhone") {
				SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
				//writer.write(smphone.GetId().toString()+",Smartphone,"+smphone.GetCount()+","+smphone.GetName()+","+smphone.GetPrice()+","+smphone.GetCompany()+","+smphone.GetModel()+","+smphone.GetOs()+","+smphone.GetParam1()+","+smphone.GetParam2()+"\r\n");		
				System.out.println("Тип устройства - смартфон\n"); 
				System.out.println("ID устройства: "+smphone.GetId().toString()+"\n"); 
				System.out.println("Количество: "+smphone.GetCount()+"\n"); 
				System.out.println("Название: "+smphone.GetName()+"\n");   
				System.out.println("Цена: "+smphone.GetPrice()+"\n"); 
				System.out.println("Производитель: "+smphone.GetCompany()+"\n"); 
				System.out.println("Модель: "+smphone.GetModel()+"\n");
				System.out.println("Система: "+smphone.GetOs()+"\n");	
				System.out.println("Тип SIM-карты: "+smphone.GetParam1()+"\n");
				System.out.println("Число SIM-карт: "+smphone.GetParam2()+"\n");				
			}  
			else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Book") {
				Book book = (Book)m_PurchasingItemsList.get(j);
				//writer.write(book.GetId().toString()+",Book,"+book.GetCount()+","+book.GetName()+","+book.GetPrice()+","+book.GetCompany()+","+book.GetModel()+","+book.GetOs()+","+book.GetParam1()+","+book.GetParam2()+"\r\n");
				System.out.println("Тип устройства - планшет\n"); 
				System.out.println("ID устройства: "+book.GetId().toString()+"\n"); 
				System.out.println("Количество: "+book.GetCount()+"\n"); 
				System.out.println("Название: "+book.GetName()+"\n");   
				System.out.println("Цена: "+book.GetPrice()+"\n"); 
				System.out.println("Производитель: "+book.GetCompany()+"\n"); 
				System.out.println("Модель: "+book.GetModel()+"\n");
				System.out.println("Система: "+book.GetOs()+"\n");	
				System.out.println("Процессор: "+book.GetParam1()+"\n");
				System.out.println("Разрешение экрана: "+book.GetParam2()+"\n");				 
			}	
		}		
	}		
	
}
