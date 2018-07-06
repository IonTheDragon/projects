	import java.util.UUID;
	public class SmartPhone extends Device{
		String sim;
		String simCount;
		public void create() {
			super.create();
			sim = "Sample Type";
			simCount = "1";
		}
		public void update(String m_name, String m_price, String m_company, String m_model, String m_os, String m_sim, String m_simCount) {
			super.update(m_name, m_price, m_company, m_model, m_os);
			sim = m_sim;
			simCount = m_simCount;
		}	
		public void read() {
			super.read();
			System.out.print("Тип SIM-карты ");
			System.out.println(sim);
			System.out.print("Количество SIM-карт ");
			System.out.println(simCount);									
		}	
		public void delete() {
			super.delete();
			sim = "";
			simCount = "";
		}					
		SmartPhone() {
			super();
		}
		SmartPhone(UUID id) {
			super(id);
		}	
	}
