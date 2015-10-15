<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="xml" />
<xsl:template match="/">
	<items>
			<xsl:for-each select="/items/item[quantity != 0 or holdon != 0]">
			<item>
					<xsl:variable name="id" select="id"> </xsl:variable>
					
					<id><xsl:value-of select="id" /></id>
					<name><xsl:value-of select="name" /></name>
					<price><xsl:value-of select="price" /></price>
					<quantity><xsl:value-of select="quantity" /></quantity>
					<holdon><xsl:value-of select="holdon" /></holdon>
					<sold><xsl:value-of select="sold" /></sold>					
			</item>
			</xsl:for-each>
	
	</items>
</xsl:template>
</xsl:stylesheet>
