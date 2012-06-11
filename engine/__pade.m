function [E F] = __pade(delay,n,m)
	if (nargin==1)
		n=3;
		m=4;
	end
	if delay^2<1E-5
		E=1;
		F=1;
	else
		if (n==3 && m==4)
			E = [delay^4/840 delay^3*2/105 delay^2*1/7 delay*4/7 1];
			F = [-delay^3/210 delay^2/14 -3*delay/7 1];
		elseif (n==3 && m==3)
			E=[delay^3/120 delay^2/10 delay/2 1];
			F=[-delay^3/120 delay^2/10 -delay/2 1];
                elseif (n==1 && m==1)
                        E=[0.5*delay 1];
                        F=[-0.5*delay 1];
		end
	end
end