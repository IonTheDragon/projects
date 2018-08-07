import java.util.*;
import java.io.*;
import org.json.CDL;
import org.json.JSONArray;
import org.json.JSONObject;

public class ManagerOrderJSON extends AManageOrder {

	ManagerOrderJSON(String m_path){
		super(m_path);
	}
	
	public void readById(UUID m_id){
		
	  StringBuilder data = new StringBuilder();
      try {
         FileReader reader = new FileReader(new File(path));
		int ch;
		while ((ch = reader.read()) != -1) {
			data.append((char)ch);
		}
			reader.close();
			
			StringBuilder CurrentData = new StringBuilder();
			CurrentData.append("<order>\r\n");
			CurrentData.append("<user>\r\n");
			CurrentData.append("<userId>\r\n");
			int firstindex = data.lastIndexOf(m_id.toString());
			int lastindex = data.indexOf("<order>",firstindex);
			if (firstindex != -1 && data.lastIndexOf(m_id.toString()+"</itemId>") == -1) {
				for (int i = firstindex; i < lastindex; i++) {
					char m_ch = data.charAt(i);
					CurrentData.append(m_ch);
				}
				System.out.print(CurrentData);
			}
			else System.out.print("ID не найден");
      }
      catch(IOException e) {
		e.printStackTrace();
	  }	 
	  		
	}
	
	public void saveById(Orders m_orders, UUID m_id){

		File m_file = new File(path);
		try {
			BufferedWriter writer = new BufferedWriter(new FileWriter(m_file,true));
			
			Order m_order = this.getOrderById(m_orders, m_id);
			ArrayList<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;
			writer.write("<order>\r\n");
			//writer.write("Id устройства,Тип устройства,Количество,Название,Цена,Изготовитель,Модель,ОС,корпус/карта/процессор,число карт/разрешение,Id покупателя,Имя,Фамилия,Отчество,Почта,Статус заказа\r\n");
			User user = m_order.OurUser;
				writer.write("<user>\r\n");
					writer.write("<userId>"+user.id.toString()+"</userId>\r\n");
					writer.write("<FirstName>"+user.Name+"</FirstName>\r\n");
					writer.write("<SecondName>"+user.Sname+"</SecondName>\r\n");
					writer.write("<FatherName>"+user.FatherName+"</FatherName>\r\n");
					writer.write("<mail>"+user.Mail+"</mail>\r\n");
				writer.write("</user>\r\n");
			//writer.write(",,,,,,,,,,"+user.id.toString()+","+user.Name+","+user.Sname+","+user.FatherName+","+user.Mail+","+m_order.Status+"\r\n");			
			//
			for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
			 writer.write("<device>\r\n");					
			 if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Phone") {
				 Phone phone = (Phone)m_PurchasingItemsList.get(j);
				 writer.write("<itemId>"+phone.GetId().toString()+"</itemId>\r\n");
				 writer.write("<Type>Phone</Type>\r\n");
				 writer.write("<count>"+phone.GetCount()+"</count>\r\n");
				 writer.write("<itemName>"+phone.GetName()+"</itemName>\r\n");
				 writer.write("<price>"+phone.GetPrice()+"</price>\r\n");
				 writer.write("<company>"+phone.GetCompany()+"</company>\r\n");
				 writer.write("<model>"+phone.GetModel()+"</model>\r\n");
				 writer.write("<system>"+phone.GetOs()+"</system>\r\n");
				 writer.write("<hull>"+phone.GetParam1()+"</hull>\r\n");
				 //writer.write(phone.GetId().toString()+",Phone,"+phone.GetCount()+","+phone.GetName()+","+phone.GetPrice()+","+phone.GetCompany()+","+phone.GetModel()+","+phone.GetOs()+","+phone.GetParam1()+"\r\n");		
			 }
			 else if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="SmartPhone") {
			 	 SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
				 writer.write("<itemId>"+smphone.GetId().toString()+"</itemId>\r\n");
				 writer.write("<Type>Smartphone</Type>\r\n");
				 writer.write("<count>"+smphone.GetCount()+"</count>\r\n");
				 writer.write("<itemName>"+smphone.GetName()+"</itemName>\r\n");
				 writer.write("<price>"+smphone.GetPrice()+"</price>\r\n");
				 writer.write("<company>"+smphone.GetCompany()+"</company>\r\n");
				 writer.write("<model>"+smphone.GetModel()+"</model>\r\n");
				 writer.write("<system>"+smphone.GetOs()+"</system>\r\n");
				 writer.write("<simType>"+smphone.GetParam1()+"</simType>\r\n");
				 writer.write("<simCount>"+smphone.GetParam2()+"</simCount>\r\n");			 	 
				 //writer.write(smphone.GetId().toString()+",Smartphone,"+smphone.GetCount()+","+smphone.GetName()+","+smphone.GetPrice()+","+smphone.GetCompany()+","+smphone.GetModel()+","+smphone.GetOs()+","+smphone.GetParam1()+","+smphone.GetParam2()+"\r\n");		
			 }  
			 else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Book") {
				 Book book = (Book)m_PurchasingItemsList.get(j);
				 writer.write("<itemId>"+book.GetId().toString()+"</itemId>\r\n");
				 writer.write("<Type>Book</Type>\r\n");
				 writer.write("<count>"+book.GetCount()+"</count>\r\n");
				 writer.write("<itemName>"+book.GetName()+"</itemName>\r\n");
				 writer.write("<price>"+book.GetPrice()+"</price>\r\n");
				 writer.write("<company>"+book.GetCompany()+"</company>\r\n");
				 writer.write("<model>"+book.GetModel()+"</model>\r\n");
				 writer.write("<system>"+book.GetOs()+"</system>\r\n");
				 writer.write("<processor>"+book.GetParam1()+"</processor>\r\n");
				 writer.write("<resolution>"+book.GetParam2()+"</resolution>\r\n");				 
				 //writer.write(book.GetId().toString()+",Book,"+book.GetCount()+","+book.GetName()+","+book.GetPrice()+","+book.GetCompany()+","+book.GetModel()+","+book.GetOs()+","+book.GetParam1()+","+book.GetParam2()+"\r\n");
			 }
			 writer.write("</device>\r\n");	
			}
			writer.write("</order>\r\n");		
			//
			writer.flush();
			writer.close();
		}
		catch(IOException e) {
			e.printStackTrace();
		}	
	}
	
	public void saveAll(Orders m_orders){
	
		File m_file = new File(path);
		try {
			BufferedWriter writer = new BufferedWriter(new FileWriter(m_file,true));
			//writer.write("Id устройства,Тип устройства,Количество,Название,Цена,Изготовитель,Модель,ОС,корпус/карта/процессор,число карт/разрешение,Id покупателя,Имя,Фамилия,Отчество,Почта,Статус заказа\r\n");
			for (int i = 0; i < m_orders.OrdersList.size(); i++) {

				Order m_order = (Order)m_orders.OrdersList.get(i);
				ArrayList<Device> m_PurchasingItemsList = m_order.PurchasingItemsList;
				
				User user = m_order.OurUser;
					writer.write("<user>\r\n");
						writer.write("<userId>"+user.id.toString()+"</userId>\r\n");
						writer.write("<FirstName>"+user.Name+"</FirstName>\r\n");
						writer.write("<SecondName>"+user.Sname+"</SecondName>\r\n");
						writer.write("<FatherName>"+user.FatherName+"</FatherName>\r\n");
						writer.write("<mail>"+user.Mail+"</mail>\r\n");
					writer.write("</user>\r\n");
			//writer.write(",,,,,,,,,,"+user.id.toString()+","+user.Name+","+user.Sname+","+user.FatherName+","+user.Mail+","+m_order.Status+"\r\n");			
				//
				for (int j = 0; j < m_PurchasingItemsList.size(); j++) {
					writer.write("<device>\r\n");					
						if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Phone") {
							Phone phone = (Phone)m_PurchasingItemsList.get(j);
							writer.write("<itemId>"+phone.GetId().toString()+"</itemId>\r\n");
							writer.write("<Type>Phone</Type>\r\n");
							writer.write("<count>"+phone.GetCount()+"</count>\r\n");
							writer.write("<itemName>"+phone.GetName()+"</itemName>\r\n");
							writer.write("<price>"+phone.GetPrice()+"</price>\r\n");
							writer.write("<company>"+phone.GetCompany()+"</company>\r\n");
							writer.write("<model>"+phone.GetModel()+"</model>\r\n");
							writer.write("<system>"+phone.GetOs()+"</system>\r\n");
							writer.write("<hull>"+phone.GetParam1()+"</hull>\r\n");
			//writer.write(phone.GetId().toString()+",Phone,"+phone.GetCount()+","+phone.GetName()+","+phone.GetPrice()+","+phone.GetCompany()+","+phone.GetModel()+","+phone.GetOs()+","+phone.GetParam1()+"\r\n");		
						}
						else if (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="SmartPhone") {
							SmartPhone smphone = (SmartPhone)m_PurchasingItemsList.get(j);
							writer.write("<itemId>"+smphone.GetId().toString()+"</itemId>\r\n");
							writer.write("<Type>Smartphone</Type>\r\n");
							writer.write("<count>"+smphone.GetCount()+"</count>\r\n");
							writer.write("<itemName>"+smphone.GetName()+"</itemName>\r\n");
							writer.write("<price>"+smphone.GetPrice()+"</price>\r\n");
							writer.write("<company>"+smphone.GetCompany()+"</company>\r\n");
							writer.write("<model>"+smphone.GetModel()+"</model>\r\n");
							writer.write("<system>"+smphone.GetOs()+"</system>\r\n");
							writer.write("<simType>"+smphone.GetParam1()+"</simType>\r\n");
							writer.write("<simCount>"+smphone.GetParam2()+"</simCount>\r\n");			 	 
			//writer.write(smphone.GetId().toString()+",Smartphone,"+smphone.GetCount()+","+smphone.GetName()+","+smphone.GetPrice()+","+smphone.GetCompany()+","+smphone.GetModel()+","+smphone.GetOs()+","+smphone.GetParam1()+","+smphone.GetParam2()+"\r\n");		
						}  
						else if  (m_PurchasingItemsList.get(j).getClass().getSimpleName()=="Book") {
							Book book = (Book)m_PurchasingItemsList.get(j);
							writer.write("<itemId>"+book.GetId().toString()+"</itemId>\r\n");
							writer.write("<Type>Book</Type>\r\n");
							writer.write("<count>"+book.GetCount()+"</count>\r\n");
							writer.write("<itemName>"+book.GetName()+"</itemName>\r\n");
							writer.write("<price>"+book.GetPrice()+"</price>\r\n");
							writer.write("<company>"+book.GetCompany()+"</company>\r\n");
							writer.write("<model>"+book.GetModel()+"</model>\r\n");
							writer.write("<system>"+book.GetOs()+"</system>\r\n");
							writer.write("<processor>"+book.GetParam1()+"</processor>\r\n");
							writer.write("<resolution>"+book.GetParam2()+"</resolution>\r\n");				 
			//writer.write(book.GetId().toString()+",Book,"+book.GetCount()+","+book.GetName()+","+book.GetPrice()+","+book.GetCompany()+","+book.GetModel()+","+book.GetOs()+","+book.GetParam1()+","+book.GetParam2()+"\r\n");
						}
						writer.write("</device>\r\n");	
				}
				writer.write("</order>\r\n");			
				//		
			}
			writer.flush();
			writer.close();
		}
		catch(IOException e) {
			e.printStackTrace();
		}	
	
	}	
}
