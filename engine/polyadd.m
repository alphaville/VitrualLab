function s = polyadd(p,q)
%POLYADD adds two polynomials
        
        np=length(p);
        nq=length(q);
        if (np>=nq)
            s=p;
            small=q;
            n=np;
            m=nq;
        else
            s=q;
            small=p;
            n=nq;
            m=np;
        end
        for i=1:m
            s(end-i+1)=s(end-i+1)+small(end-i+1);
        end
end