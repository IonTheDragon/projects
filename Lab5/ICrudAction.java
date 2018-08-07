	interface ICrudAction {
		void create();
		void read();
		void update(String m_count, String m_name, String m_price, String m_company, String m_model, String m_os, String m_arg, String m_arg2);
		void delete();
	}
