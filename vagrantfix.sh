#!/bin/sh

#run this file if the (new) vageant box wont startup correctly after errors about the VBoxGuestAdditions
vagrant ssh -c 'sudo ln -s /opt/VBoxGuestAdditions-4.3.10/lib/VBoxGuestAdditions /usr/lib/VBoxGuestAdditions'
vagrant reload