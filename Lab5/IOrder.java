import java.util.*;	
	interface IOrder {
		void readById(UUID m_id);
		void saveById(Orders m_orders, UUID m_id);
		void readAll();
		void saveAll(Orders m_orders);
	}
