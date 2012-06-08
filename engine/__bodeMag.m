function mag = __bodeMag(P,Q,omega)
%__BODEMAG Calculates the Magnitude of G(jw), where G(s)=P(s)e^{td*s}/Q(s)
%Note that the delay does not affect the Bode magnitude
% 
%Input:
%- P, Q: Numerator and denominator of the transfer function
%- omega: frequency at which we need to calculate the bode module
%
%Output:
%The value of |G(jw)|

jomega=omega*1i;
mag = abs(polyval(P,jomega))/abs(polyval(Q,jomega));