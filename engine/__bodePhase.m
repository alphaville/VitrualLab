function phase = __bodePhase(P,Q,delay,omega)
%__BODEPHASE returns the phase of a transfer function G(s)=P(s)e^{-td*s}/Q(s)
%at a given frequency w, i.e. arg[G(jw)].
%
%Input:
%- P,Q: Numerator and denominator of the transfer function
%- delay: The delay of the system
%- omega: The frequency at which we need to calculate the phase
%
%Output:
%Returns the value of arg[G(jw)] at the given frequency w.

jomega=1i*omega;
phase=arg( polyval(P,jomega)/polyval(Q,jomega))-delay*omega;
