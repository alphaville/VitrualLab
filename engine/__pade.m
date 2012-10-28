function [E F] = __pade(delay,n,m)
%%__PADE calculates the Pade approximation of the function exp(-t_d*s) - where
%t_d is a positive delay.
%
%Input:
%delay	The delay t_d.
%n,m The order of the Pade approximation. The following combinations of 
% orders are currently available: (n,m)=(1,1), (3,3) and (3,4). For very low
% delays, (1,1)-order approximation is fine.
%
%Output:
%The Pade approximation is a rational approximation of the exponential
%function f(s)=exp(-t_d*s). In other words, it returns two polynomials
%E and F so that f(s)~E(s)/F(s).

        _delay = -delay;
	if (nargin==1)
		n=3;
		m=4;
	end
	if delay^2<1E-5
		E=1;
		F=1;
	else
		if (n==3 && m==4)
			E = [_delay^4/840 _delay^3*2/105 _delay^2*1/7 _delay*4/7 1];
			F = [-_delay^3/210 _delay^2/14 -3*_delay/7 1];
		elseif (n==3 && m==3)
			E=[_delay^3/120 _delay^2/10 _delay/2 1];
			F=[-_delay^3/120 _delay^2/10 -_delay/2 1];
                elseif (n==1 && m==1)
                        E=[0.5*_delay 1];
                        F=[-0.5*_delay 1];
		end
	end
end
