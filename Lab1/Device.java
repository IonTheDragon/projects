	import java.util.UUID;
	abstract public class Device implements ICrudAction{
		UUID id;
		String name;
		String price;
		static int count;
		String company;
		String model;
		String os;
		Device(){
			id = UUID.randomUUID();
		}
		Device(UUID id){
			this.id = id;
		}		
		public void create() {
			count++;
			name = "Sample name";
			price = "10000";
			company = "Sample company";
			model = "Sample model";
			os = "Sample OS";
		}
		public void read() {
			System.out.print("ID ");
			System.out.println(id);	
			System.out.print("№ объекта ");
			System.out.println(count);						
			System.out.print("Название ");
			System.out.println(name);
			System.out.print("Цена ");
			System.out.println(price);
			System.out.print("Изготовитель ");
			System.out.println(company);
			System.out.print("Модель ");
			System.out.println(model);
			System.out.print("Платформа ");
			System.out.println(os);		
		}		
		public void update(String m_name, String m_price, String m_company, String m_model, String m_os) {
			name = m_name;
			price = m_price;
			company = m_company;
			model = m_model;
			os = m_os;
		}	
		public void delete() {
			name = "";
			price = "0";
			company = "";
			model = "";
			os = "";		
			if (count>0) count--;
		}
	}
