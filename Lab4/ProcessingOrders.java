import java.util.*;

public class ProcessingOrders implements Runnable {
	int v_Time;
	int d_Time;
	int g_Time;
	int v_count;
	int d_count;
	Orders orders;
	String mode;
	Validate ValThread;
	DeleteValidatedOrders DelThread;
	GenerateOrders GenThread;	
	//Thread thread;	
	
	ProcessingOrders(int m_vtime, int m_dtime, int m_gtime, int m_vcount, int m_dcount, Orders m_orders, String m_mode) {
		this.v_Time = m_vtime;
		this.d_Time = m_dtime;
		this.g_Time = m_gtime;
		this.v_count = m_vcount;
		this.d_count = m_dcount;
		this.orders = m_orders;
		this.mode = m_mode;
		this.ValThread = new Validate(v_Time, v_count, orders, mode);
		this.DelThread = new DeleteValidatedOrders(d_Time, d_count, orders, mode);
		this.GenThread = new GenerateOrders(g_Time);	
		//thread = new Thread(this, "Поток проверки и удаления заказов");
		//thread.start();				
	}	
	
	@Override
	public void run() {	
	 try{	 
		int oldindex = 0;
		int newindex = 0;
		
		for (int i = 0; i < ValThread.count; i++) {
			Thread.sleep(500);
			for (int j = oldindex; j < GenThread.OutputList.size(); j++) {
				ValThread.orders.Buy(GenThread.OutputList.get(j));
				newindex += 1;
			}		
			oldindex = newindex;	
			
			this.orders = ValThread.orders;			
			Thread.sleep(ValThread.Time+500);
			DelThread.orders = ValThread.orders;
			this.orders = ValThread.orders;	
			Thread.sleep(DelThread.Time+500);
			ValThread.orders = DelThread.orders;
			this.orders = DelThread.orders;	
		}
	 }
	 catch(InterruptedException e){
		System.out.println("Thread has been interrupted");
	 }	 
	}
	
	public void show() {
		orders.show();
	}
}
