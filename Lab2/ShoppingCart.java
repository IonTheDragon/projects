import java.util.*;

public class ShoppingCart {
 ArrayList<Device> ShoppingCartList = new ArrayList<>();
 
 public void add(String type, String m_count, String m_name, String m_price, String m_company, String m_model, String m_os, String m_param1, String m_param2) {
	 if ("Phone".equalsIgnoreCase(type)) {
		ShoppingCartList.add(new Phone(m_count,m_name, m_price, m_company, m_model, m_os, m_param1, m_param2));
	 }
	 else if ("Smartphone".equalsIgnoreCase(type)) {
		ShoppingCartList.add(new SmartPhone(m_count,m_name, m_price, m_company, m_model, m_os, m_param1, m_param2));
	 }
	 else if ("Book".equalsIgnoreCase(type)) {
		ShoppingCartList.add(new Book(m_count, m_name, m_price, m_company, m_model, m_os, m_param1, m_param2));
	 }	 
 }
 
 public void delete(UUID m_id) { 
	 ArrayList<Device> deleteCandidates = new ArrayList<>();

 // Pass 1 - collect delete candidates
     for (Device device : ShoppingCartList) {
		if (device.GetId()==m_id) {
			deleteCandidates.add(device);
        }
     }

 // Pass 2 - delete
	 for (Device deleteCandidate : deleteCandidates) {
		ShoppingCartList.remove(deleteCandidate);
	 }
 } 
 
 public void show() { 
 	 	 
	Object[][] data = new Object[10][ShoppingCartList.size()];	 
	for (int i = 0; i < ShoppingCartList.size(); i++) {
		data[0][i] = ShoppingCartList.get(i).GetDeviceType();
		data[1][i] = ShoppingCartList.get(i).GetId().toString();
		data[2][i] = ShoppingCartList.get(i).GetCount();
		data[3][i] = ShoppingCartList.get(i).GetName();
		data[4][i] = ShoppingCartList.get(i).GetPrice();
		data[5][i] = ShoppingCartList.get(i).GetCompany();
		data[6][i] = ShoppingCartList.get(i).GetModel();
		data[7][i] = ShoppingCartList.get(i).GetOs();
		data[8][i] = ShoppingCartList.get(i).GetParam1();
		data[9][i] = ShoppingCartList.get(i).GetParam2();	
	}  
	System.out.println("________________________");	
	for (int i = 0; i < ShoppingCartList.size(); i++) {
		System.out.println("Идентификатор: "+data[1][i]);
		System.out.println("Тип устройства: "+data[0][i]);
		System.out.println("Количество: "+data[2][i]);
		System.out.println("Название: "+data[3][i]);
		System.out.println("Цена: "+data[4][i]);
		System.out.println("Изготовитель: "+data[5][i]);
		System.out.println("Модель: "+data[6][i]);
		System.out.println("ОС: "+data[7][i]);
		if ("Phone".equalsIgnoreCase(ShoppingCartList.get(i).GetDeviceType())) {
			System.out.println("Тип корпуса: "+data[8][i]);
		}
		else if ("Smartphone".equalsIgnoreCase(ShoppingCartList.get(i).GetDeviceType())) {
			System.out.println("Тип SIM-карты: "+data[8][i]);
			System.out.println("Число SIM-карт: "+data[9][i]);
		}
		else if ("Book".equalsIgnoreCase(ShoppingCartList.get(i).GetDeviceType())) {
			System.out.println("Процессор: "+data[8][i]);
			System.out.println("Разрешение экрана: "+data[9][i]);			
		}
		System.out.println("________________________");
	}	
  }
  public UUID readId(int i) {
	 return ShoppingCartList.get(i).GetId(); 
  }
  
  public void search(UUID m_id) {
	int is_found = 0;
	for (int i = 0; i < ShoppingCartList.size(); i++) {
		
		if (m_id==ShoppingCartList.get(i).GetId()) {
			System.out.println("________________________");	
			System.out.println("Товар найден");
			System.out.println("________________________");	
			System.out.println("Тип устройства: "+ShoppingCartList.get(i).GetDeviceType());
			System.out.println("Количество: "+ShoppingCartList.get(i).GetCount());
			System.out.println("Название: "+ShoppingCartList.get(i).GetName());
			System.out.println("Цена: "+ShoppingCartList.get(i).GetPrice());
			System.out.println("Изготовитель: "+ShoppingCartList.get(i).GetCompany());
			System.out.println("Модель: "+ShoppingCartList.get(i).GetModel());
			System.out.println("ОС: "+ShoppingCartList.get(i).GetOs());
			if ("Phone".equalsIgnoreCase(ShoppingCartList.get(i).GetDeviceType())) {
				System.out.println("Тип корпуса: "+ShoppingCartList.get(i).GetParam1());
			}
			else if ("Smartphone".equalsIgnoreCase(ShoppingCartList.get(i).GetDeviceType())) {
				System.out.println("Тип SIM-карты: "+ShoppingCartList.get(i).GetParam1());
				System.out.println("Число SIM-карт: "+ShoppingCartList.get(i).GetParam2());
			}
			else if ("Book".equalsIgnoreCase(ShoppingCartList.get(i).GetDeviceType())) {
				System.out.println("Процессор: "+ShoppingCartList.get(i).GetParam1());
				System.out.println("Разрешение экрана: "+ShoppingCartList.get(i).GetParam2());			
			}
			System.out.println("________________________");	
			is_found = 1;
			break;		
		}
	}
		if (is_found==0) {
			System.out.println("Товар не найден");	
			System.out.println("________________________");	
		}	 	  
  }
 }

