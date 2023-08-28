from lxml import etree
from signxml import XMLSigner
import sys

def get_xml_tree_root():
    try:
        with open(sys.argv[1], 'rb') as f:
            xml_data = f.read()
        root = etree.fromstring(xml_data)
        target_ns = "http://www.w3.org/2000/09/xmldsig#"
        new_root = set_namsespace(root, target_ns)
        return new_root
    except Exception as e:
        print(f"Error: {e}")
        return None

def get_signed_xml(root):
    try:
        signature = etree.SubElement(root,'{http://www.w3.org/2000/09/xmldsig#}Signature',Id='placeholder',nsmap={ None: 'http://www.w3.org/2000/09/xmldsig#' })
        signed_root = XMLSigner(c14n_algorithm='http://www.w3.org/2001/10/xml-exc-c14n#').sign(
            root,
            key=open(sys.argv[2]).read(),
            cert=open(sys.argv[3]).read()
        )
        return signed_root
    except Exception as e:
        print(f"Error: {e}")
        return None

def set_namsespace(root, target_nt):
    """
    Set the target_nt to be default namespace
    """
    # set the target_nt to be default namespace
    new_nsmap = root.nsmap.copy()
    for ns_key, ns_value in root.nsmap.items():
        if ns_value == target_nt:
            del new_nsmap[ns_key]
            new_nsmap[None] = target_nt

    # make the updated root
    root_attrib_dict = dict(root.attrib)
    new_root = etree.Element(root.tag, attrib=root_attrib_dict, nsmap=new_nsmap)

    # copy other properties
    new_root.text = root.text
    new_root.tail = root.tail

    # call recursively
    for old_root in root[:]:
        new_root.append(set_namsespace(old_root, target_nt))

    return new_root

if __name__ == '__main__':
    new_root = get_xml_tree_root()
    if new_root is not None:
        signed_root = get_signed_xml(new_root)
        if signed_root is not None:
            try:
                signed_xml_file = open(sys.argv[4],'wb')
                signed_xml_file.write(etree.tostring(signed_root,encoding='UTF-8'))
                signed_xml_file.close()
                with open(sys.argv[4], 'wb') as f:
                    f.write(etree.tostring(signed_root, pretty_print=True, xml_declaration=True, encoding='UTF-8'))
                print("{\"success\" : true}")
            except Exception as e:
                print("{\"success\" : false}")
        else:
            print("{\"success\" : false}")
    else:
        print("{\"success\" : false}")
