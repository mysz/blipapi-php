# -*- coding: utf-8 -*-
# $Id$
#
# Blip! (http://blip.pl) communication library.
# Author: Marcin Sztolcman <marcin /at/ urzenia /dot/ net>
# Version: 0.02.04
# Copyright: (r) 2009 Marcin Sztolcman
# License: http://opensource.org/licenses/gpl-license.php GNU Public License v.2

from _utils import arr2qstr

def read (since_id=None, user=None, include=None, limit=10, offset=0):
    url = '/dashboard'
    if user:
        url = '/users/' + str (user) + url

    if since_id:
        url += '/since/' + str (since_id)

    params = dict ()

    if limit:
        params['limit'] = str (limit)
    if offset:
        params['offset'] = str (offset)
    if include:
        params['include'] = ','.join (include)

    if params:
        url += '?' + arr2qstr (params)

    return (url, 'get', None, None)
