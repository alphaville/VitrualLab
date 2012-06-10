function [E F] = __pade(delay)
	if delay^2<1E-5
		E=1;
		F=1;
	else
		E = [delay^4/840 delay^3*2/105 delay^2*1/7 delay*4/7 1];
		F = [-delay^3/210 delay^2/14 -3*delay/7 1];
	end
end