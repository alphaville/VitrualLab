function [wc Ku] = __crossover(P,Q,delay)
	%%__CROSSOVER solves the equation arg G(j*wc)=-pi
	pi=3.1415;
	log_init=1.5;
	log_end=2.5;
	n_points = 1500;
	log_step=(log_end-log_init)/n_points;
	tol=1e-1;
	wc=[];
	log_omega = log_init:log_step:log_end;
		for i=log_omega			
			omega = 10^i;
			err=abs(__bodePhase(P,Q,delay,omega)+pi);
			disp([num2str(omega) ' >>> ' num2str(__bodePhase(P,Q,delay,omega))]);
			if (err<tol)
				wc=omega;
				break;
			end
		end
	if (!isempty(wc))
		Ku=1/__bodeMag(P,Q,wc);
	end
end