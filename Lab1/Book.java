	import java.util.UUID;
	public class Book extends Device{
		String proc;
		String resolution;
		public void create() {
			super.create();
			proc = "Пень";
			resolution = "900x1920";
		}
		public void update(String m_name, String m_price, String m_company, String m_model, String m_os, String m_proc, String m_resolution) {
			super.update(m_name, m_price, m_company, m_model, m_os);
			proc = m_proc;
			resolution = m_resolution;
		}	
		public void read() {
			super.read();
			System.out.print("Процессор ");
			System.out.println(proc);
			System.out.print("Разрешение экрана ");
			System.out.println(resolution);									
		}	
		public void delete() {
			super.delete();
			proc = "";
			resolution = "";
		}					
		Book() {
			super();
		}
		Book(UUID id) {
			super(id);
		}	
	}
